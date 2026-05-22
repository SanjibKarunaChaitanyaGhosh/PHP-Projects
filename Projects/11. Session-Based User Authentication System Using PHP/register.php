<?php
include 'db.php';

$message = "";

if(isset($_POST['register'])){

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Password Hashing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check existing email
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if(mysqli_num_rows($result) > 0){
        $message = "<p class='error'>Email already exists!</p>";
    } else {

        $sql = "INSERT INTO users(fullname, email, password)
                VALUES('$fullname','$email','$hashedPassword')";

        if(mysqli_query($conn, $sql)){
            $message = "<p class='success'>Registration Successful!</p>";
        } else {
            $message = "<p class='error'>Registration Failed!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Register</h2>

    <?php echo $message; ?>

    <form method="POST">

        <input type="text" name="fullname" placeholder="Full Name" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="register">Register</button>

    </form>

    <p>Already have account? <a href="login.php">Login</a></p>

</div>

</body>
</html>