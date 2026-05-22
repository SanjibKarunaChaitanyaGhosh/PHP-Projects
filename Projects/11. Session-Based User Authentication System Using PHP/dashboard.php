<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Dashboard</h2>

    <p>Welcome, <b><?php echo $_SESSION['user']; ?></b></p>

    <p>Email: <?php echo $_SESSION['email']; ?></p>

    <a href="logout.php">
        <button>Logout</button>
    </a>

</div>

</body>
</html>