<?php

$name = $_POST['name'];

$sub1 = $_POST['sub1'];
$sub2 = $_POST['sub2'];
$sub3 = $_POST['sub3'];
$sub4 = $_POST['sub4'];
$sub5 = $_POST['sub5'];

$total = $sub1 + $sub2 + $sub3 + $sub4 + $sub5;

$percentage = $total / 5;

if($percentage >= 90)
    $grade = "A+";
elseif($percentage >= 80)
    $grade = "A";
elseif($percentage >= 70)
    $grade = "B";
elseif($percentage >= 60)
    $grade = "C";
elseif($percentage >= 50)
    $grade = "D";
else
    $grade = "Fail";

?>

<!DOCTYPE html>
<html>
<head>
<title>Result</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h2>Student Result</h2>

<p><b>Name:</b> <?php echo $name; ?></p>

<p><b>Total Marks:</b> <?php echo $total; ?></p>

<p><b>Percentage:</b> <?php echo $percentage; ?>%</p>

<p><b>Grade:</b> <?php echo $grade; ?></p>

<br>

<a href="index.php">Calculate Again</a>

</div>

</body>
</html>