<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

$servername="localhost";
$username="root";
$password="root";
$dbname="darbic_db";

$conn = mysqli_connect(
$servername,
$username,
$password,
$dbname,
3306
);

if(!$conn){
die("Connection failed: ".mysqli_connect_error());
}

if(!$conn){
 die("Connection failed: ".mysqli_connect_error());
}
?>