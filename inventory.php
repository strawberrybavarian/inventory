<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit();
}
include("dbconnection.php");

$u_firstname = $_SESSION['u_firstname'];


$query = "SELECT * FROM products";
$result = mysqli_query($dbconnect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inventory Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Hello <?= htmlspecialchars($u_firstname); ?></h1>
    <h2>Inventory Management System</h2>
    <a href="add_product.php" class="btn btn-success mb-3">Add Product</a>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Type</th>
                <th>Available</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($product = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                    <?php if ($product['p_image']) { ?>
                        <img src="uploads/<?= $product['p_image']; ?>" width="50" height="50" alt="Product Image">
                    <?php } else { ?>
                        No Image
                    <?php } ?>
                </td>
                <td><?= htmlspecialchars($product['p_name']); ?></td>
                <td><?= $product['p_quantity']; ?></td>
                <td><?= htmlspecialchars($product['p_description']); ?></td>
                <td><?= htmlspecialchars($product['p_type']); ?></td>
                <td><?= $product['p_available'] ? 'Yes' : 'No'; ?></td>
                <td><?= $product['p_created_at']; ?></td>
                <td><?= $product['p_updated_at']; ?></td>
                <td>
                    <a href="edit_product.php?p_id=<?= $product['p_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete_product.php?p_id=<?= $product['p_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this product?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
