<?php
include 'config/db.php';

$id = $_GET['id'];

$query = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $query);

$post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $post['title']; ?></title>
</head>
<body>

<h1><?php echo $post['title']; ?></h1>

<img src="uploads/<?php echo $post['image']; ?>" width="400">

<p><?php echo $post['content']; ?></p>

</body>
</html>