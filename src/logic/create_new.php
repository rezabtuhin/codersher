<?php
session_start();
include("../config/dbconfig.php");
include("../config/constant.php");
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}

if (isset($_POST['createP'])){
    $uniId = uniqid($_SESSION['currUser']);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $title = openssl_encrypt($_POST['title'], $cipher, $key, $options, $iv);
    $diff = openssl_encrypt($_POST['diff'], $cipher, $key, $options, $iv);
    $author = $_SESSION['id'];
    $iv = bin2hex($iv);
    $stmt = $conn->prepare("INSERT INTO problem_set(author, title,handle, diff, iv) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $author, $title, $uniId, $diff, $iv);
    if ($stmt->execute() === TRUE) {
        $tmts = $conn->prepare("CREATE TABLE `$uniId` (`id` INT NOT NULL AUTO_INCREMENT , `input` TEXT NOT NULL , `output` TEXT NOT NULL , PRIMARY KEY (`id`))");
        $tmts->execute();
        header('location: ../problem.php');
    }
    else{
        echo "ERROR";
    }
}
