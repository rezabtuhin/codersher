<?php
session_start();
if(isset($_SESSION['id'])){
    header('location: ./home.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>CODERSHER | Signup</title>

</head>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header><img src="../assets/SVG/LOGO HORIZONTAL 2.svg" alt=""></header>
                <form action="./logic/regiUser.php" method="POST">
                    <div class="field input-field">
                        <input type="text" name="username" id="username" placeholder="Username" class="input" required
                            onInput="checkForUser()">
                        <h6 id="uError">
                            <?php
                            if (isset($_SESSION['unameerr'])) {
                                echo $_SESSION['unameerr'];
                                unset($_SESSION['unameerr']);
                            }
                            ?>
                        </h6>
                    </div>
                    <div class="field input-field">
                        <input type="email" name="email" id="email" placeholder="Email" class="input" required
                            onInput="checkForEmail()">
                        <h6 id="eError">
                            <?php
                            if (isset($_SESSION['existE'])) {
                                echo $_SESSION['existE'];
                                unset($_SESSION['existE']);
                            }
                            ?>
                        </h6>
                    </div>

                    <div class="field input-field">
                        <input type="password" name="password" id="password" placeholder="Password" class="password"
                            required onInput="checkPass()">
                        <h6 id="pError">
                            <?php
                            if (isset($_SESSION['specialError'])) {
                                echo $_SESSION['specialError'];
                                unset($_SESSION['specialError']);
                            }
                            ?>
                        </h6>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="field input-field">
                        <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password"
                            class="password" required onInput="checkConPass()">
                        <h6 id="cpError">
                            <?php
                            if (isset($_SESSION['dmatch'])) {
                                echo $_SESSION['dmatch'];
                                unset($_SESSION['dmatch']);
                            }
                            ?>
                        </h6>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field button-field">
                        <button id="submit" name="register">Signup</button>
                    </div>
                </form>

                <div class="form-link">
                    <span>Already have an account? <a href="./login.php">Login</a></span>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="./js/signup.js"></script>
</body>

</html>