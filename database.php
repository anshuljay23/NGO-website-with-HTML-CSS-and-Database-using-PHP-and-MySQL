<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "mini_project";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something Went Wrong;");
}
?>
