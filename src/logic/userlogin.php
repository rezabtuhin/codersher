<?php
session_start();
include("../config/dbconfig.php");
$isv;
$pass;
$id = 0;
if (isset($_POST['login']) && isset($_POST['csrf_token']) && isset($_POST['username']) && isset($_POST['password']) && isset($_SESSION['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) < 1) {
            $_SESSION['logerr'] = "Username or Password is incorrect.";
            header('location: ../login.php');
            exit();
        } else {
            while ($row = $result->fetch_assoc()) {
                $isv = $row['isVerified'];
                $pass = $row['password'];
                $id = $row['id'];
            }
            if ($isv != 1) {
                $_SESSION["username"] = $username;
                header('location: ../otp.php');
                exit();
            } else {
                if (password_verify($password, $pass)) {
                    //                echo "login successful";
                    $_SESSION['id'] = $id;
                    $_SESSION['currUser'] = $username;
                    header('location: ../home.php');
                } else {
                    $_SESSION['logerr'] = "Username or Password is incorrect.";
                    header('location: ../login.php');
                    exit();
                }
            }
        }
    } else {
        $_SESSION['logerr'] = "Invalid credential";

        header('location: ../login.php');
    }


} else {
    $_SESSION['logerr'] = "Field can not be empty";
    header('location: ../login.php');


}


?>