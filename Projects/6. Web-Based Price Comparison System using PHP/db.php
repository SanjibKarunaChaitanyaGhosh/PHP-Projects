<?php

$server="localhost";
$user="admin";
$password="";
$dbname="price_compare";

$conn = mysqli_connect("localhost","root","","price_compare");
$conn=new mysqli($server,$user,$password,$dbname);


$conn=new mysqli($server,$user,$password,$dbname);

if(!$conn)
{
    die("Connection failed");
}
?>