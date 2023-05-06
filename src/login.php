<?php
    session_start();
    if(isset($_SESSION['id'])){
        header('location: ./home.php');
    }



    $token = bin2hex(random_bytes(32)); // Generate a 32-byte random string
    $csrf_token = hash('sha256', $token); // Hash the random string using SHA-256

    // $token = md5(uniqid(rand(), true));
    $_SESSION['csrf_token'] = $token;
    $_SESSION['csrf_token_time'] = time();

    // print_r($_SESSION);

    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>CODERSHER | Login</title>
</head>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header><img src="../assets/SVG/LOGO HORIZONTAL 2.svg" alt=""></header>
                <form action="./logic/userlogin.php" method="POST">

                    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" required>
                    <div class="field input-field">

                        <input type="text" placeholder="Username" name="username" class="input" required>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Password" name="password" class="password" required>
                        <i class='bx bx-hide eye-icon'></i>

                    </div>

                    <div class="form-link">
                        <a href="#" class="forgot-pass">Forgot password?</a>
                    </div>

                    <div class="field button-field">
                        <button name="login">Login</button>
                    </div>
                    <?php if (isset($_SESSION['error'])) { ?>
                        <p class="error">
                            <?php echo $_SESSION['error'];
                            unset($_SESSION['error']); ?>
                        </p>
                    <?php } ?>
                </form>

                <div class="form-link">
                    <span>Don't have an account? <a href="./signup.php">Signup</a></span>

                </div>
                <h6 id="uError" style="color: #8a202e; font-size: 14px; text-align:center; margin-top: 10px;">
                    <?php
                        if(isset($_SESSION['logerr'])){
                            echo $_SESSION['logerr'];
                            unset($_SESSION['logerr']);
                        }
                    ?>
                </h6>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="./js/login.js"></script>
</body>

</html>