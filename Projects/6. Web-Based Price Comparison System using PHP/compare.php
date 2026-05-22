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

<h2>Price Comparison</h2>

<?php

$product=$_GET['product'];

$query="SELECT * FROM products
WHERE product_name='$product'
ORDER BY price ASC";

$result=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result))
{

echo "Store: ".$row['store_name']."<br>";
echo "Price: ₹".$row['price']."<br><br>";

}

?>

</div>

</body>
</html>