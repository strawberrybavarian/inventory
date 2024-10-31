<?php
$server = "localhost";
$username = "root"; 
$password = "";     
$database = "inventory_db";


$dbconnect = mysqli_connect($server, $username, $password, $database);

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
