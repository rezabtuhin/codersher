<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}
include("../config/dbconfig.php");
include("../config/constant.php");


$si = data_encrypt($_POST['si'],$_SESSION['iv']);
$so = data_encrypt($_POST['so'],$_SESSION['iv']);
$table = $_SESSION['handle'];
$stmt = $conn->prepare("INSERT INTO `$table` (`input`, `output`) VALUES (?, ?)");
$stmt->bind_param("ss", $si, $so);
$stmt->execute();
echo "Successfully added record.";