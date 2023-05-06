<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}

if (isset($_POST['logout'])){
    unset($_SESSION['id']);
    unset($_SESSION['currUser']);
    session_destroy();
    header('location: ../login.php');
}