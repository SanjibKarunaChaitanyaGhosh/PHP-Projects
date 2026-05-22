<?php

$number = $_POST['number'];
$operation = $_POST['operation'];

switch($operation)
{

case "prime":

if ($number <= 1)
{
echo "$number is NOT a Prime Number";
}
else
{
$flag = 1;

for ($i = 2; $i <= $number/2; $i++)
{
if ($number % $i == 0)
{
$flag = 0;
break;
}
}

if ($flag == 1)
echo "$number is a Prime Number";
else
echo "$number is NOT a Prime Number";

}

break;


case "palindrome":

$temp = $number;
$reverse = 0;

while ($temp > 0)
{
$digit = $temp % 10;
$reverse = ($reverse * 10) + $digit;
$temp = (int)($temp / 10);
}

if ($number == $reverse)
echo "$number is a Palindrome Number";
else
echo "$number is NOT a Palindrome Number";

break;


case "factorial":

$fact = 1;

for ($i = 1; $i <= $number; $i++)
{
$fact = $fact * $i;
}

echo "Factorial of $number is: $fact";

break;

}

?>