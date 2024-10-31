<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit();
}
include("dbconnection.php");

if (isset($_GET['p_id'])) {
    $p_id = mysqli_real_escape_string($dbconnect, $_GET['p_id']);

    // Delete the product image if exists
    $query = "SELECT p_image FROM products WHERE p_id = '$p_id'";
    $result = mysqli_query($dbconnect, $query);
    if ($result && mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
        if ($product['p_image']) {
            unlink("uploads/" . $product['p_image']);
        }
    }

    $query = "DELETE FROM products WHERE p_id = '$p_id'";
    if (mysqli_query($dbconnect, $query)) {
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($dbconnect);
    }
} else {
    header("Location: inventory.php");
    exit();
}
?>
