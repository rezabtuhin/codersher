<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPmailer\PHPmailer\Exception;

require 'C:\xampp\htdocs\codersher\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\codersher\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\codersher\phpmailer\src\SMTP.php';

include("../config/dbconfig.php");
if (isset($_POST['register'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $regex = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]*$/';
    if (!preg_match($regex, $password)) {
        $_SESSION['specialError'] = "Must be combination of alphanumeric and special chars.";
        header('location: ../signup.php');
        exit();
    }
    if ($password !== $cpassword) {
        $_SESSION['dmatch'] = "Password didn't match.";
        header('location: ../signup.php');
        exit();
    }

    if (preg_match('/\s|[^A-Za-z0-9]/', $username)) {
        $_SESSION['unameerr'] = "Username must be space or special characterless";
        header('location: ../signup.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['unameerr'] = "Username already taken";
        header('location: ../signup.php');
        exit();
    }

    $stmt2 = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $stmt2->store_result();
    if ($stmt2->num_rows > 0) {
        $_SESSION['existE'] = "Email already taken";
        header('location: ../signup.php');
        exit();
    }

    try {
        $token = bin2hex(random_bytes(4));
    } catch (Exception $e) {
    }
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'codersher5@gmail.com';
    $mail->Password = 'utrbwuvbxzzdznsr';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = '465';

    $mail->setFrom('codersher5@gmail.com', 'CODERSHER');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'CODESHER Account Verification';
    $mail->Body = '<link rel="preconnect" href="https://fonts.googleapis.com">
                 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                 <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                 <div style="display: flex; align-items: center; justify-content: center">
                     <div style="width: 100%; background-color: #1C1A25">
                         <div style="padding: 30px">
                             <div>
                                 <img src="https://images2.imgbox.com/e9/7b/TMDV939i_o.png" width="200">
                             </div>
                             <div style="color: white; font-family: ' . 'Poppins' . ', sans-serif; font-size: 14px">
                                 <p>Hello ' . $username . ',</p>
                                 <p>Please use the verification code below on the CODERSHER verification page.</p>
                                 <h1 style="text-align: center; letter-spacing: 5px; color: slateblue">' . $token . '</h1>
                                 <p>If you are not requesting this, Contact Us.</p>
                                 <p>Regards,<br><span style="color: slateblue; font-weight: bold">CODERSHER™</span> Team</p>
                             </div>
                         </div>
                     </div>
                
                     </div>';
    $mail->send();

    $isV = 0;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $hashed_token = password_hash($token, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user (username, email, password, 	isVerified , token) VALUES (?, ?, ?,?, ?)");
    $stmt->bind_param("sssis", $username, $email, $hashed_password, $isV, $hashed_token);
    if ($stmt->execute() === TRUE) {
        $_SESSION['username'] = $username;
        header('location: ../otp.php');
    } else {
        header('location: ../signup.php');
    }
} else {
    header('location: ../login.php');
}

//give a coding example of securely storing user email, username, password, otp into database using php mysql