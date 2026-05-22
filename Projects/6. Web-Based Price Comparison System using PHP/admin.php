<?php include "db.php"; ?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<a href="index.php">Home</a>

<h2>Add Product</h2>

<form action="add_product.php" method="POST">

<input type="text" name="product_name"
placeholder="Product Name"><br>

<input type="text" name="store_name"
placeholder="Store Name"><br>

<input type="number" name="price"
placeholder="Price"><br>

<input type="text" name="category"
placeholder="Category"><br>

<button type="submit">Add Product</button>

</form>


<h2>Product List</h2>

<?php

$query="SELECT * FROM products";

$result=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result))
{

echo "Product: ".$row['product_name']."<br>";
echo "Store: ".$row['store_name']."<br>";
echo "Price: ₹".$row['price']."<br>";

echo "<a href='delete_product.php?id=".$row['id']."'>Delete</a>";

echo "<hr>";

}

?>

</div>

</body>
</html>