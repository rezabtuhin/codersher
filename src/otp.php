<?php
session_start();
include("./config/dbconfig.php");
if (!isset($_SESSION['username'])){
    header('location: ./login.php');
}
$email;
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $_SESSION["username"]);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $email = $row["email"];
}
$split_email = explode("@", $email);
$username = $split_email[0];
$masked_username = substr($username, 0, 3) . str_repeat("*", strlen($username) - 3);
$masked_email = $masked_username . "@" . $split_email[1];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>CODERSHER | VERIFY</title>
</head>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header><img src="../assets/SVG/LOGO HORIZONTAL 2.svg" alt=""></header>
                <h5 style="color: slateblue;">A 8 digit OTP sent to this Email:
                    <?php echo $masked_email ?>
                </h5>
                <form action="./logic/acc_ver.php" method="POST">
                    <div class="field input-field">
                        <input type="text" placeholder="Your 8 digit OTP" class="input" name="otp_b" required>
                        <h6 id="uError">
                            <?php
                            if (isset($_SESSION['wt'])) {
                                echo $_SESSION['wt'];
                                unset($_SESSION['wt']);
                            }
                            ?>
                        </h6>
                    </div>
                    <div class="field button-field">
                        <button id="submit" name="verify">Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>