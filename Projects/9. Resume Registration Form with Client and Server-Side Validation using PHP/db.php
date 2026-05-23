<?php


$server="localhost";
$user="admin";
$password="12345";
$dbname="Clientt_ServerSide_Validation";

error_reporting(E_ALL);
ini_set('display_errors',1);


// $conn = mysqli_connect("localhost","root","","price_compare");
$conn=new mysqli($server,$user,$password,$dbname);

if(!$conn)
{
    die("Connection failed");
}
?>