<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "ccbd_online_exam";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>