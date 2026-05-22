<?php
session_start();

if(isset($_SESSION['user'])){
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Authentication System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Welcome</h2>

    <p><a href="register.php">Register</a></p>
    <p><a href="login.php">Login</a></p>
</div>

</body>
</html>