<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit();
}
include("dbconnection.php");

if (isset($_GET['p_id'])) {
    $p_id = mysqli_real_escape_string($dbconnect, $_GET['p_id']);
    $query = "SELECT * FROM products WHERE p_id = '$p_id'";
    $result = mysqli_query($dbconnect, $query);
    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
    } else {
        header("Location: inventory.php");
        exit();
    }
} else {
    header("Location: inventory.php");
    exit();
}

if (isset($_POST['edit_product'])) {
    $p_name = mysqli_real_escape_string($dbconnect, $_POST['p_name']);
    $p_quantity = mysqli_real_escape_string($dbconnect, $_POST['p_quantity']);
    $p_description = mysqli_real_escape_string($dbconnect, $_POST['p_description']);
    $p_type = mysqli_real_escape_string($dbconnect, $_POST['p_type']);
    $p_available = isset($_POST['p_available']) ? 1 : 0;


    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
        $target_dir = "uploads/";
        $unique_name = uniqid() . "_" . basename($_FILES["p_image"]["name"]);
        $target_file = $target_dir . $unique_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

      
        $check = getimagesize($_FILES["p_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["p_image"]["tmp_name"], $target_file)) {
         
                $p_image = $unique_name;
      
                if ($product['p_image']) {
                    unlink("uploads/" . $product['p_image']);
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "File is not an image.";
        }
    } else {
        $p_image = $product['p_image'];
    }

    if (!isset($error)) {
        $query = "UPDATE products SET p_image = '$p_image', p_name = '$p_name', p_quantity = '$p_quantity', p_description = '$p_description', p_type = '$p_type', p_available = '$p_available' WHERE p_id = '$p_id'";
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
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Edit Product</h1>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php } ?>
    <form method="POST" action="edit_product.php?p_id=<?= $product['p_id']; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="p_image" class="form-label">Product Image</label>
            <?php if ($product['p_image']) { ?>
                <img src="uploads/<?= $product['p_image']; ?>" width="50" height="50" alt="Product Image">
            <?php } ?>
            <input type="file" class="form-control" id="p_image" name="p_image">
        </div>
        <div class="mb-3">
            <label for="p_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="p_name" name="p_name" value="<?= htmlspecialchars($product['p_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="p_quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="p_quantity" name="p_quantity" value="<?= $product['p_quantity']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="p_description" class="form-label">Description</label>
            <textarea class="form-control" id="p_description" name="p_description" rows="3"><?= htmlspecialchars($product['p_description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="p_type" class="form-label">Type</label>
            <select class="form-select" id="p_type" name="p_type" required>
                <option value="">Select Type</option>
                <option value="Solid" <?= $product['p_type'] == 'Solid' ? 'selected' : ''; ?>>Solid</option>
                <option value="Liquid" <?= $product['p_type'] == 'Liquid' ? 'selected' : ''; ?>>Liquid</option>
                <option value="Gas" <?= $product['p_type'] == 'Gas' ? 'selected' : ''; ?>>Gas</option>
            </select>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="p_available" name="p_available" <?= $product['p_available'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="p_available">
                Available
            </label>
        </div>
        <button type="submit" class="btn btn-primary" name="edit_product">Update Product</button>
        <a href="inventory.php" class="btn btn-secondary">Back to Inventory</a>
    </form>
</div>
</body>
</html>
