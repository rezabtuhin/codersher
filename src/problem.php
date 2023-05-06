<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}
include("./config/dbconfig.php");
include("./config/constant.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="./css/problem.css">
    <title>My Problems</title>
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
                    <div class="m-3 links d-flex flex-column">
                        <a href="problem.php" class="p-2">Create Problems</a>
                        <div class="line"></div>
                        <a href="problemList.php" class="p-2">Problem list</a>
                        <div class="line"></div>
                        <a href="mySubmission.php" class="p-2">My submission</a>

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <h6 class="tag">Problems</h6>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="card bg-dark">
                            <div class="header m-3 d-flex align-items-center justify-content-between">
                                <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 700;">Problem List</h6>
                                <button type="button" class="create-prob px-3 py-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class="fa-solid fa-square-plus me-2"></i>Create
                                    New</button>
                            </div>
                            <div class="line"></div>
                            <div class="lists d-flex flex-column">
                                <?php
                                    $stmt = $conn->prepare("SELECT * FROM problem_set WHERE author = ?");
                                    $stmt->bind_param("i", $_SESSION['id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $data = $row['id'];
                                        $csrf_tokens = bin2hex(random_bytes(32));
                                        $_SESSION['editToken'.$data] = $csrf_tokens;
                                        $iv = hex2bin($row['iv']);
                                        $title = openssl_decrypt($row['title'], $cipher, $key, $options, $iv);
                                        $diff = openssl_decrypt($row['diff'], $cipher, $key, $options, $iv);

                                        ?>
                                        <div class="listx">
                                            <a href="./edit.php?proX=<?php echo urldecode($data) ?>&token=<?php echo urldecode($csrf_tokens) ?>"
                                               class="p-3 py-3 d-flex align-items-center justify-content-between">
                                                    <?php
                                                        echo $title;
                                                        if ($diff == 'Easy'){
                                                            ?>
                                                            <span class="px-2"
                                                                   style="font-size: 15px; border: 1px solid lawngreen; border-radius: 3px; color: lawngreen"><?php echo $diff ?></span>
                                                            <?php
                                                        }
                                                        else if ($diff == 'Medium'){
                                                            ?>
                                                            <span class="px-2"
                                                                   style="font-size: 15px; border: 1px solid sandybrown; border-radius: 3px; color: sandybrown"><?php echo $diff ?></span>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <span class="px-2"
                                                                   style="font-size: 15px; border: 1px solid red; border-radius: 3px; color: red"><?php echo $diff ?></span>
                                                            <?php
                                                        }
                                                    ?>

                                            </a>
                                            <div class="linex"></div>
                                        </div>
                                        <?php
                                    }
                                ?>

                            </div>
                        </div>
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



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content bg-dark">
                <form action="./logic/create_new.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"
                            style="font-family: 'Montserrat', sans-serif;font-weight: 700; font-size: 18px;">Create new
                            problem</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 problem-field">
                            <label for="exampleFormControlInput1" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="exampleFormControlInput1"
                                style="background-color: #262a33; border: none;color: white;">
                        </div>
                        <div class="mb-3 problem-field">
                            <label for="exampleFormControlInput1" class="form-label">Difficulty</label>
                            <select class="form-select" name="diff" aria-label="Default select example"
                                style="background-color: #262a33; border: none; color: white;" required>
                                <option selected disabled>Open this select menu</option>
                                <option value="Easy">Easy</option>
                                <option value="Medium">Medium</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="create-prob px-2" data-bs-dismiss="modal"
                            style="background-color: #c0c0c0; color: black;">Close</button>
                        <input type="submit" name="createP" class="create-prob px-2" value="Create"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./js/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</body>

</html>