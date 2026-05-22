<?php

include "db.php";

$id = $_GET['id'];

$query = "SELECT filename FROM documents WHERE id=$id";

$result = mysqli_query($conn,$query);

$row = mysqli_fetch_assoc($result);

$file = $row['filename'];

unlink("uploads/".$file);

mysqli_query($conn,"DELETE FROM documents WHERE id=$id");

header("Location:view.php");

?>