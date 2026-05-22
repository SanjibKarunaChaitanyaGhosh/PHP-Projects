<?php

$name = $_POST['name'];

$marks = array(
    $_POST['sub1'],
    $_POST['sub2'],
    $_POST['sub3'],
    $_POST['sub4'],
    $_POST['sub5']
);

$total = array_sum($marks);

$average = $total / count($marks);

$highest = max($marks);

$lowest = min($marks);


/* Grade Logic */

if($average >= 90)
    $grade = "A+";

elseif($average >= 75)
    $grade = "A";

elseif($average >= 60)
    $grade = "B";

elseif($average >= 50)
    $grade = "C";

else
    $grade = "Fail";

?>

<!DOCTYPE html>
<html>
<head>
<title>Result Page</title>
</head>

<body>

<h2>Student Result</h2>

Student Name: <?php echo $name; ?>

<h3>Marks Details</h3>

<table border="1">

<tr>
<th>Subject</th>
<th>Marks</th>
</tr>

<?php

for($i=0; $i<5; $i++)
{
echo "<tr>";
echo "<td>Subject ".($i+1)."</td>";
echo "<td>".$marks[$i]."</td>";
echo "</tr>";
}

?>

</table>

<br>

Total Marks: <?php echo $total; ?> <br>

Average Marks: <?php echo $average; ?> <br>

Highest Marks: <?php echo $highest; ?> <br>

Lowest Marks: <?php echo $lowest; ?> <br>

Grade: <?php echo $grade; ?>



</body>
</html>