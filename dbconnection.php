<?php
$server = "localhost";
$username = "root"; // Adjust if necessary
$password = "";     // Adjust if necessary
$database = "inventory_db";

// Create a connection
$dbconnect = mysqli_connect($server, $username, $password, $database);

// Check if the connection was successful
if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
