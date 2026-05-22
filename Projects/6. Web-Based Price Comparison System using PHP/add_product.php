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

</div>

</body>
</html>