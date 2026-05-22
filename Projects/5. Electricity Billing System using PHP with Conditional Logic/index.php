<!DOCTYPE html>
<html>
<head>
    <title>Electricity Billing System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h2>Electricity Billing System</h2>

<form method="POST">

Customer Name:
<input type="text" name="name" required>

Units Consumed:
<input type="number" name="units" required>

<button type="submit" name="calculate">
Calculate Bill

</button>

</form>

<?php

if(isset($_POST['calculate']))
{
    $name = $_POST['name'];
    $units = $_POST['units'];

    if($units <= 50)
    {
        $bill = $units * 3.5;
    }

    elseif($units <= 150)
    {
        $bill = $units * 4.0;
    }

    elseif($units <= 250)
    {
        $bill = $units * 5.2;
    }

    else
    {
        $bill = $units * 6.5;
    }

    echo "<h3>Customer Name: $name</h3>";
    echo "<h3>Total Units: $units</h3>";
    echo "<h3>Total Bill: ₹ $bill</h3>";
}

?>

</div>

</body>
</html>