<?php

$host = "localhost";
$user = "admin";
$password = "";
$database = "auth_system";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>