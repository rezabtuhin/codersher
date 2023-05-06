<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: ./login.php');
}
include("../config/dbconfig.php");
include("../config/constant.php");
$i = 1;
$table = $_SESSION['handle'];
$stmt = $conn->prepare("SELECT * FROM `$table`");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $input = data_decrypt($row['input'], $_SESSION['iv']);
    $output = data_decrypt($row['output'],$_SESSION['iv']);
    echo "<tr><td>".$i."</td><td>".$input."</td><td>".$output."</td></tr>";
    $i+=1;
}