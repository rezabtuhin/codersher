<?php
include("../config/dbconfig.php");
if (!empty($_POST["username"])) {
    $uname = mysqli_real_escape_string($conn, $_POST['username']);
    if (strpos($uname, " ") !== false) {
        echo "Username should not contain spaces.";
    } else {
        $query = "SELECT * FROM `user` WHERE `username` = '$uname'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo "Username already taken. Try another one.";
            $userTrack = 1;
        }
    }
}

if (!empty($_POST["email"])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if (strpos($email, " ") !== false) {
        echo "Email should not contain spaces.";
    } else {
        $query = "SELECT * FROM `user` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo "Email already taken. Try another one.";
            $emailTrack = 1;
        }
    }
}