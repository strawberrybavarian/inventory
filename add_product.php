<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit();
}
include("dbconnection.php");

if (isset($_POST['add_product'])) {
    $p_name = mysqli_real_escape_string($dbconnect, $_POST['p_name']);
    $p_quantity = mysqli_real_escape_string($dbconnect, $_POST['p_quantity']);
    $p_description = mysqli_real_escape_string($dbconnect, $_POST['p_description']);
    $p_type = mysqli_real_escape_string($dbconnect, $_POST['p_type']);
    $p_available = isset($_POST['p_available']) ? 1 : 0;

    // Handle image upload
    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
        $target_dir = "uploads/";
        $unique_name = uniqid() . "_" . basename($_FILES["p_image"]["name"]);
        $target_file = $target_dir . $unique_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the uploads directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Check if image file is actual image
        $check = getimagesize($_FILES["p_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["p_image"]["tmp_name"], $target_file)) {
                // File uploaded successfully
                $p_image = $unique_name;
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "File is not an image.";
        }
    } else {
        $p_image = null;
    }

    if (!isset($error)) {
        $query = "INSERT INTO products (p_image, p_name, p_quantity, p_description, p_type, p_available) VALUES ('$p_image', '$p_name', '$p_quantity', '$p_description', '$p_type', '$p_available')";
        if (mysqli_query($dbconnect, $query)) {
            header("Location: inventory.php");
            exit();
        } else {
            $error = "Error: " . mysqli_error($dbconnect);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Add Product</h1>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php } ?>
    <form method="POST" action="add_product.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="p_image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="p_image" name="p_image">
        </div>
        <div class="mb-3">
            <label for="p_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="p_name" name="p_name" required>
        </div>
        <div class="mb-3">
            <label for="p_quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="p_quantity" name="p_quantity" required>
        </div>
        <div class="mb-3">
            <label for="p_description" class="form-label">Description</label>
            <textarea class="form-control" id="p_description" name="p_description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="p_type" class="form-label">Type</label>
            <select class="form-select" id="p_type" name="p_type" required>
                <option value="">Select Type</option>
                <option value="Solid">Solid</option>
                <option value="Liquid">Liquid</option>
                <option value="Gas">Gas</option>
            </select>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="p_available" name="p_available" checked>
            <label class="form-check-label" for="p_available">
                Available
            </label>
        </div>
        <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
        <a href="inventory.php" class="btn btn-secondary">Back to Inventory</a>
    </form>
</div>
</body>
</html>
