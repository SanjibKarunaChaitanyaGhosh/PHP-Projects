<?php include "db.php"; ?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<a href="index.php">Home</a>
<a href="admin.php">Admin Panel</a>

<h2>Search Results</h2>

<?php

$product=$_GET['product'];

$query="SELECT * FROM products
WHERE product_name LIKE '%$product%'";

$result=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result))
{

echo "Product: ".$row['product_name']."<br>";
echo "Store: ".$row['store_name']."<br>";
echo "Price: ₹".$row['price']."<br>";

echo "<a href='compare.php?product=".$row['product_name']."'>Compare Price</a>";

echo "<hr>";

}

?>

</div>

</body>
</html>