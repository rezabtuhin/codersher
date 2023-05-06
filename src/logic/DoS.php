<?php
function checkIP($request)
{
    $ip = $request->ip;
    $conn = new mysqli('host', 'username', 'password', 'database');
    $query = "SELECT * FROM ip_table WHERE ip = '$ip'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastRequestTime = strtotime($row['last_request_time']);
        $currentTime = time();
        if ($currentTime - $lastRequestTime >= 300) {
            $query = "UPDATE ip_table SET counter = 200 WHERE ip = '$ip'";
            $conn->query($query);
        } else {
            $query = "UPDATE ip_table SET counter = counter - 1 WHERE ip = '$ip'";
            $conn->query($query);
        }
    } else {
        $query = "INSERT INTO ip_table (ip, counter) VALUES ('$ip', 200)";
        $conn->query($query);
    }
    $query = "SELECT counter FROM ip_table WHERE ip = '$ip'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $counter = $row['counter'];
    $conn->close();
    if ($counter === 0) {
        return true;
    } else {
        return false;
    }
}

function main()
{
    $request = (object) [
        'ip' => '127.0.0.1',
    ];

    if (checkIP($request)) {
        banIP($request->ip);
    }
}
function banIP($ip)
{
    $conn = new mysqli('host', 'username', 'password', 'database');
    $query = "INSERT INTO banned_ips (ip) VALUES ('$ip')";
    $conn->query($query);
    $conn->close();
}
main();
?>