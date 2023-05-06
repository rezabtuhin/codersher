
<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="./css/index.css">
    <title>CODERSHER | Home</title>
</head>

<body>
    <nav class="navbar sticky-top navbar-dark bg-dark">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand" href="home.php">
                <img src="../assets/SVG/LOGO 2.svg" alt="" width="90">
            </a>
        </div>
    </nav>

    <div class="container-fluid my-3" style="min-height: 73vh;">
        <div class="row">
            <div class="col-md-3 ">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="profile-image d-flex justify-content-center mb-2">
                            <img src="../assets/basic avatar.png" alt="" width="100">
                        </div>
                        <div class="user-info mb-4">
                            <p class="name"><?php echo $_SESSION['currUser'] ?> </p>
                            <span class="rank">
                                newbie
                            </span>
                        </div>
                        <div class="user-history mb-4">
                            <table>
                                <tbody>
                                <tr>
                                    <td>Participated</td>
                                    <td>: N/A</td>
                                </tr>
                                <tr>
                                    <td>Hosted</td>
                                    <td>: N/A</td>
                                </tr>
                                <tr>
                                    <td>Submissions</td>
                                    <td>: N/A</td>
                                </tr>
                                <tr>
                                    <td>Rating</td>
                                    <td>: N/A</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="actions d-flex align-items-center justify-content-evenly">
                            <a href=""><i class="fa-solid fa-user" style="color: #c0c0c0;"></i></a>
                            <form action="./logic/logout.php" method="POST">
                                <button name="logout" style="background-color: transparent; border: none;"><a><i class="fa-solid fa-right-from-bracket" style="color: #c0c0c0;"></i></a></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark mt-2">
                    <div class="m-3 links d-flex flex-column" style="">
                        <a href="problem.php" class="p-2" style="">Create Problems</a>
                        <div class="line"></div>
                        <a href="problemList.php" class="p-2" style="">Problem list</a>
                        <div class="line"></div>
                        <a href="mySubmission.php" class="p-2" style="">My submission</a>

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="cardss">
                        <a href="">
                            <div class="cardx">
                                <img src="../assets/300ppi/host1.png" alt="" width="180" class="mb-4" draggable="false">
                                <div class="titles mt-1">
                                    <i class="fa-solid fa-person-running me-2"></i>
                                    <h5>Participate Contest</h5>
                                </div>
                            </div>
                        </a>
                        <a href="contest.html">
                            <div class="cardx">
                                <img src="../assets/300ppi/contest.png" alt="" width="250" class="mb-2" draggable="false">
                                <div class="titles mt-1">
                                    <i class="fa-solid fa-microphone-lines me-2"></i>
                                    <h5>Host Contest</h5>
                                </div>
                            </div>
                        </a>
                        <a href="problem.php">
                            <div class="cardx">
                                <img src="../assets/300ppi/create.png" alt="" width="300" draggable="false">
                                <div class="titles mt-1">
                                    <i class="fa-solid fa-square-plus me-2"></i>
                                    <h5>Create Problems</h5>
                                </div>
                            </div>
                        </a>
                        <a href="problemList.php">
                            <div class="cardx">
                                <img src="../assets/300ppi/bulb.png" alt="" width="200" draggable="false">
                                <div class="titles mt-1">
                                    <i class="fa-solid fa-square-plus me-2"></i>
                                    <h5>Practice Problems</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="footer" style="background-color: #212529;">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-4 container">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    <img src="../assets/SVG/LOGO HORIZONTAL 2.svg" alt="" width="120">
                </a>
                <span class="mb-3 mb-md-0 text-muted">© 2023 Company, Inc</span>
            </div>
    
            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3">
                    <a class="text-muted" href="#">
                        <i class="fa-brands fa-facebook" style="color: #c0c0c0;"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="text-muted" href="#">
                        <i class="fa-brands fa-linkedin" style="color: #c0c0c0;"></i>
                    </a>
                </li>
            </ul>
        </footer>
    </div>

    <script src="./js/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</body>

</html>