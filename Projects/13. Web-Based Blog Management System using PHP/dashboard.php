<?php
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
}
?>

<h1>Welcome <?php echo $_SESSION['user']; ?></h1>

<a href="add_post.php">Add Blog</a>
<a href="manage_posts.php">Manage Blogs</a>
<a href="logout.php">Logout</a>