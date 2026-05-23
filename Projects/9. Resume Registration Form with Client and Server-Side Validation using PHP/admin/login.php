<?php
session_start();
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = MD5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $user;
        header("Location: dashboard.php");
    } else {
        echo "Invalid Login";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button>Login</button>
</form>