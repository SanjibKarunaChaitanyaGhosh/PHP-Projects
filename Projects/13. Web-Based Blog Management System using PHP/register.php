<?php
include 'config/db.php';

if(isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users(username,email,password)
              VALUES('$username','$email','$password')";

    mysqli_query($conn, $query);

    header("Location: login.php");
}
?>

<form method="POST">

    <input type="text" name="username" placeholder="Username">

    <input type="email" name="email" placeholder="Email">

    <input type="password" name="password" placeholder="Password">

    <button name="register">Register</button>

</form>