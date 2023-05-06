<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}
include("./config/dbconfig.php");
include("./config/constant.php");
$proX = $_GET['proX'];
$token = $_GET['token'];
$_SESSION['proX'] = $proX;
$_SESSION['token'] = $token;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="./css/problem.css">
    <title>Edit problem</title>
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
            <div class="row d-flex align-items-center">
                <div class="col-md-10"><h6 class="tag">Edit</h6></div>
                <div class="col-md-2">

                </div>
            </div>
            <?php
                if ($_SESSION['editToken'.$proX] !== $token){
                    ?>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="card bg-dark">
                                <div class="header m-3 d-flex align-items-center justify-content-between">
                                    <h6 class="text-center" style="font-family: 'Montserrat', sans-serif; font-weight: 700;">Error parsing information</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                else{
                    $stmt = $conn->prepare("SELECT * FROM problem_set WHERE id = ? AND author = ?");
                    $stmt->bind_param("ii", $proX, $_SESSION['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if (mysqli_num_rows($result) < 1) {
                        ?>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="card bg-dark">
                                    <div class="header m-3 d-flex align-items-center justify-content-between">
                                        <h6 class="text-center" style="font-family: 'Montserrat', sans-serif; font-weight: 700;">You are not authorized to edit this page</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    else{
                        $title = "";
                        $handle = "";
                        $diff = "";
                        $description = "";
                        $sample_input = "";
                        $sample_output = "";
                        $mem_limit = "";
                        $time_limit = "";
                        $iv = "";
                        while ($row = $result->fetch_assoc()) {
                            $iv = hex2bin($row['iv']);
                            $title = data_decrypt($row['title'], $iv);
                            $handle = $row['handle'];
                            $diff = data_decrypt($row['diff'], $iv);
                            $description = data_decrypt($row['description'], $iv);
                            $sample_input = data_decrypt($row['sample_input'], $iv);
                            $sample_output = data_decrypt($row['sample_output'], $iv);
                            $mem_limit = data_decrypt($row['mem_limit'], $iv);
                            $time_limit = data_decrypt($row['time_limit'], $iv);
                        }
                        $_SESSION['iv'] = $iv;
                        $_SESSION['handle'] = $handle;
                        ?>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="card bg-dark">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <style>
                                                .nav-link{
                                                    color: white;
                                                }
                                                .nav-link:hover{
                                                    color: white;
                                                }
                                            </style>
                                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">General</button>
                                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Test cases</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                            <div class="header m-3 d-flex align-items-center justify-content-between">
                                                <form action="./logic/editProx.php" method="POST" class="row g-3">
                                                    <div class="col-md-6">
                                                        <label for="inputEmail4" class="form-label" >Title</label>
                                                        <input type="text" name="title" class="form-control" id="inputEmail4" style="background-color: #262a33; border: none; color: white;" required value="<?php echo $title?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputPassword4" class="form-label">Difficulty</label>
                                                        <select class="form-select" name="diff" aria-label="Default select example"
                                                                style="background-color: #262a33; border: none; color: white;" required>
                                                            <?php
                                                            if ($diff == 'Easy'){
                                                                ?>

                                                                <option disabled>Open this select menu</option>
                                                                <option value="Easy" selected>Easy</option>
                                                                <option value="Medium">Medium</option>
                                                                <option value="Hard">Hard</option>

                                                                <?php
                                                            }
                                                            else if ($diff == 'Medium'){
                                                                ?>
                                                                <option disabled>Open this select menu</option>
                                                                <option value="Easy">Easy</option>
                                                                <option value="Medium" selected>Medium</option>
                                                                <option value="Hard">Hard</option>

                                                                <?php
                                                            }
                                                            else{
                                                                ?>
                                                                <option disabled>Open this select menu</option>
                                                                <option value="Easy">Easy</option>
                                                                <option value="Medium">Medium</option>
                                                                <option value="Hard" selected>Hard</option>

                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="des" class="form-label">Description</label>
                                                        <textarea class="form-control" name="des" id="des" rows="4" style="background-color: #262a33; border: none; color: white;" required><?php echo $description ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlTextarea1" class="form-label">Sample input</label>
                                                        <textarea class="form-control" name="si" id="exampleFormControlTextarea1" rows="3" style="background-color: #262a33; border: none; color: white;" required><?php echo $sample_input ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlTextarea1" class="form-label">Sample output</label>
                                                        <textarea class="form-control" name="so" id="exampleFormControlTextarea1" rows="3" style="background-color: #262a33; border: none; color: white;" required><?php echo $sample_output ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputState" class="form-label">Memory limit</label>
                                                        <input type="number" name="ml" placeholder="MB" class="form-control" id="inputZip" style="background-color: #262a33; border: none; color: white;" value="<?php echo $mem_limit ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputZip" class="form-label">Time limit</label>
                                                        <input type="number" name="tl" placeholder="Seconds" class="form-control" id="inputZip" style="background-color: #262a33; border: none; color: white;" value="<?php echo $time_limit ?>" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="submit" name="createP" class="create-prob px-2" value="Save">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                            <div class="m-3">

                                                <h5>Current test cases</h5>
                                                <table class="table table-dark table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Input</th>
                                                            <th scope="col">Output</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="test-data">
                                                    </tbody>
                                                </table>
                                                <form class="row g-3 mt-2">
                                                    <h5>Add new test cases</h5>
                                                    <div class="col-md-6">
                                                        <label for="six" class="form-label">Sample input</label>
                                                        <textarea class="form-control" name="six" id="six" rows="3" style="background-color: #262a33; border: none; color: white;" required></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="sox" class="form-label">Sample output</label>
                                                        <textarea class="form-control" name="sox" id="sox" rows="3" style="background-color: #262a33; border: none; color: white;" required></textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="submit" name="addTest" id="addTest" class="create-prob px-2" value="Save">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./js/index.js"></script>
<script>
    CKEDITOR.addCss('.cke_editable { background-color: #262a33; color: white }');
    CKEDITOR.replace('des');

    $(document).ready(function (){

        function loadTable(){
            $.ajax({
                type: 'GET',
                url: 'logic/getTest.php',
                datatype: 'html',
                success: function (data){
                    $("#test-data").html(data);
                }
            });
        }

        loadTable();
        $("#addTest").on("click", function (e){
            e.preventDefault();
            const six = $("#six").val();
            const sox = $("#sox").val();
            $.ajax({
                url: 'logic/addTest.php',
                method: 'POST',
                data: {si:six, so:sox},
                success: function (data){
                    $("#six").val("");
                    $("#sox").val("");
                    loadTable();
                },
            });
        });
    });


</script>
</body>

</html>