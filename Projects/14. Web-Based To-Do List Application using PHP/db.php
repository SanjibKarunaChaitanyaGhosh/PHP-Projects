<?php

$host = "localhost";
$dbname = "taskr";
$username = "admin";
$password = "";

$conn = new mysqli($server, $user, $password, $dbname);

if ($conn->connect_error) {

    die("Connection Failed : " . $conn->connect_error);
}

echo "Database Connected Successfully";

?>