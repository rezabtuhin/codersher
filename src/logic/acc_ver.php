<?php
session_start();
include("../config/dbconfig.php");
$token;
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $_SESSION["username"]);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $token = $row["token"];
}

if (isset($_POST['verify'])) {
    $otp = $_POST['otp_b'];
    if (password_verify($otp, $token)) {
        $isv = 1;
        $stmt = $conn->prepare("UPDATE user SET isVerified  = ? WHERE username = ?");
        $stmt->bind_param("is", $isv, $_SESSION['username']);
        $stmt->execute();
        unset($_SESSION['username']);
        session_destroy();
        header('location: ../login.php');
    } else {
        $_SESSION['wt'] = "OTP didn't match. Try again.";
        header('location: ../otp.php');
    }
}
?>