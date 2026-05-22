<?php

include "db.php";

$id = $_GET['id'];

$query = "DELETE FROM products WHERE id='$id'";

mysqli_query($conn,$query);

echo "Product Deleted Successfully";

echo "<br><br>";

echo "<a href='admin.php'>Back to Admin Panel</a>";

?>