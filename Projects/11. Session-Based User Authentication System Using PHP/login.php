<?php
session_start();
include 'db.php';

$message = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        // Verify Password
        if(password_verify($password, $user['password'])){

            $_SESSION['user'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];

            header("Location: dashboard.php");

        } else {
            $message = "<p class='error'>Invalid Password!</p>";
        }

    } else {
        $message = "<p class='error'>User Not Found!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Login</h2>

    <?php echo $message; ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>

    </form>

    <p>Don't have account? <a href="register.php">Register</a></p>

</div>

</body>
</html>