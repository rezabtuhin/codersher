<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}
include("../config/dbconfig.php");
include("../config/constant.php");
if(isset($_POST['createP'])){
    $title = data_encrypt($_POST['title'],$_SESSION['iv']);
    $diff = data_encrypt($_POST['diff'],$_SESSION['iv']);
    $des = data_encrypt($_POST['des'],$_SESSION['iv']);
    $si = data_encrypt($_POST['si'],$_SESSION['iv']);
    $so = data_encrypt($_POST['so'],$_SESSION['iv']);
    $ml = data_encrypt($_POST['ml'],$_SESSION['iv']);
    $tl = data_encrypt($_POST['tl'],$_SESSION['iv']);

    $stmt = $conn->prepare("UPDATE `problem_set` SET title = ? , diff = ? , description = ? , sample_input = ?, sample_output = ?, mem_limit = ?, time_limit = ?  WHERE id = ?");
    $stmt->bind_param("sssssssi", $title, $diff, $des, $si, $so, $ml, $tl, $_SESSION['proX']);
    $stmt->execute();
    header('location: ../edit.php?proX='.urldecode($_SESSION['proX']).'&token='.urldecode($_SESSION['token']));
    unset($_SESSION['iv']);
}


//a226197a45b99d29429eb03a86d9a5be