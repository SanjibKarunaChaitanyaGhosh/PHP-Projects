<?php include "db.php"; ?>

<!DOCTYPE html>
<html>

<head>
<title>Price Comparison System</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h2>Price Comparison System</h2>

<a href="index.php">Home</a>
<a href="admin.php">Admin Panel</a>

<h3>Search Product</h3>

<form action="search.php" method="GET">

<input type="text" name="product" placeholder="Enter product name">

<button type="submit">Search</button>

</form>

</div>

</body>
</html>