<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location: ./login.php');
}
include("./config/dbconfig.php");
include("./config/constant.php");


$proX = $_GET['proX'];
$token = $_GET['token'];
$visibility = $_GET['visibility'];
$name = $_GET['name'];
$_SESSION['curProx'] = $proX;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../codemirror/lib/codemirror.css">
    <script src="../codemirror/lib/codemirror.js"></script>
    <script src="../codemirror/mode/clike/clike.js"></script>
    <link rel="stylesheet" href="../codemirror/theme/dracula.css">
    <script src="../codemirror/addon/edit/closebrackets.js"></script>
    <script src="../codemirror/mode/python/python.js"></script>
    <link rel="stylesheet" href="../codemirror/theme/material.css">
    <link rel="stylesheet" href="./css/problem.css">
    <title><?php echo $name ?></title>
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
        <?php
            if ( $token == $_SESSION['vToken'.$proX] && $visibility == $_SESSION['visibility'.$proX] && $name == $_SESSION['name'.$proX]){
                ?>
                <div class="col-md-9">
                    <div class="row">
                        <div class="container-fluid">
                            <div class="">
                                <?php
                                    $stmt = $conn->prepare("SELECT * FROM `problem_set` WHERE `id` = ? ");
                                    $stmt->bind_param("i", $proX);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $title = "";
                                    $handle = "";
                                    $des = "";
                                    $si = "";
                                    $so = "";
                                    $ml = "";
                                    $tl = "";
                                    $iv = "";
                                    while ($row = $result->fetch_assoc()) {
                                        $iv = hex2bin($row['iv']);
                                        $title = data_decrypt($row['title'], $iv);
                                        $handle = $row['handle'];
                                        $des = data_decrypt($row['description'], $iv);
                                        $si = data_decrypt($row['sample_input'], $iv);
                                        $so = data_decrypt($row['sample_output'], $iv);
                                        $ml = data_decrypt($row['mem_limit'], $iv);
                                        $tl = data_decrypt($row['time_limit'], $iv);
                                    }
                                    $_SESSION['handle'] = $handle;
                                    $_SESSION['iv'] = $iv;
                                    ?>
                                <h3 class="text-center"><?php echo $proX.". ". $title ?></h3>
                                <p class="text-center">Time limit per test: <?php echo $tl ?> second<br>Memory limit per test: <?php echo $ml ?> megabytes<br>Input: Standard input<br>Output: Standard output</br></p>
                                <p><?php echo $des ?></p>
                                <strong>Examples</strong>
                                <div class="container-fluid">
                                    <div class="row" style="border: 1px solid white">
                                        <div class="d-flex align-items-center justify-content-between" style="border-bottom: 1px solid white">
                                            <strong class="my-1">input</strong>
                                            <button class="create-prob px-2" onclick="inputCopy()">copy</button>
                                        </div>
                                        <div style="border-bottom: 1px solid white; background-color: #262a33" ><span id="sInput"><?php echo $si ?></span></div>
                                        <div class="d-flex align-items-center justify-content-between" style="border-bottom: 1px solid white">
                                            <strong class="my-1">output</strong>
                                            <button class="create-prob px-2" onclick="outputCopy()">copy</button>
                                        </div>
                                        <div style="background-color: #262a33"><span id="sOutput"><?php echo $so ?></span></div>
                                    </div>
                                </div>

                                <?php
                                ?>
                                <div class="submission-portion mt-3">
                                    <strong>Submit your code</strong>
                                    <form class="row g-3" action="./logic/compile.php" method="POST">

                                        <div class="col-md-12">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <select class="form-select" name="lang" id="options" aria-label="Default select example" style="background-color: #282a36; border: none; border-radius: 0px; color: white;" required="">
                                                        <option value="c">C</option>
                                                        <option value="cpp">C++</option>
                                                        <option value="java">Java</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-select" name="diff" id="tOptions" aria-label="Default select example" style="background-color: #282a36; border: none; border-radius: 0px; color: white;" required="">
                                                        <option value="dracula">Dracula</option>
                                                        <option value="material">Material</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <input type="submit" name="submitCode" class="btn btn-success" style="border-radius: 0;" value="Submit code">
                                                </div>
                                            </div>
                                            <textarea id="editor" class="form-control" name="editor"></textarea>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            else{
                ?>
                <div class="col-md-9">
                    <div class="row">
                        <div class="container-fluid">
                            <div class="card bg-dark">
                                <h5 class="text-center">Error parsing data.</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>

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

<script>

    const editor = CodeMirror.fromTextArea(document.getElementById('editor'),{
        mode: "text/x-csrc",
        theme: "dracula",
        indentUnit: 7,
        lineNumbers: true,
        autoCloseBrackets: true,
    })

    document.getElementById('options').addEventListener("change", function (){
        var mode = document.getElementById("options").value;
        if (mode === 'c'){
            editor.setOption("mode", "text/x-csrc");
        }
        else if (mode === 'cpp'){
            editor.setOption("mode", "text/x-c++src");
        }
        else if (mode === 'java'){
            editor.setOption("mode", "text/x-java");
        }
    })

    document.getElementById('tOptions').addEventListener("change", function (){
        var theme = document.getElementById("tOptions").value;
        editor.setOption("theme", theme);
    })

    function inputCopy(){
        const spanText = document.getElementById("sInput").innerText+"\n";
        navigator.clipboard.writeText(spanText)
            .then(() => {
                alert("Text copied to clipboard");
            })
            .catch(err => {
                console.error("Failed to copy text: ", err);
            });
    }

    function outputCopy(){
        const spanText = document.getElementById("sOutput").innerText;
        navigator.clipboard.writeText(spanText)
            .then(() => {
                alert("Text copied to clipboard");
            })
            .catch(err => {
                console.error("Failed to copy text: ", err);
            });
    }
</script>

</body>

</html>
