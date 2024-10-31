<?php
session_start();
include("dbconnection.php");

if (isset($_POST['signup'])) {
    $u_firstname = mysqli_real_escape_string($dbconnect, $_POST['u_firstname']);
    $u_lastname = mysqli_real_escape_string($dbconnect, $_POST['u_lastname']);
    $u_age = mysqli_real_escape_string($dbconnect, $_POST['u_age']);
    $u_username = mysqli_real_escape_string($dbconnect, $_POST['u_username']);
    $u_password = mysqli_real_escape_string($dbconnect, $_POST['u_password']);
    $u_confirm_password = mysqli_real_escape_string($dbconnect, $_POST['u_confirm_password']);

    if ($u_password != $u_confirm_password) {
        $error = "Passwords do not match!";
    } else {
      
        $query = "SELECT * FROM users WHERE u_username = '$u_username'";
        $result = mysqli_query($dbconnect, $query);
        if (mysqli_num_rows($result) > 0) {
            $error = "Username already exists!";
        } else {
           
            $query = "INSERT INTO users (u_firstname, u_lastname, u_age, u_username, u_password) VALUES ('$u_firstname', '$u_lastname', '$u_age', '$u_username', '$u_password')";
            if (mysqli_query($dbconnect, $query)) {
             
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: " . mysqli_error($dbconnect);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Signup</h1>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php } ?>
    <form method="POST" action="signup.php">
        <div class="mb-3">
            <label for="u_firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="u_firstname" name="u_firstname" required>
        </div>
        <div class="mb-3">
            <label for="u_lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="u_lastname" name="u_lastname" required>
        </div>
        <div class="mb-3">
            <label for="u_age" class="form-label">Age</label>
            <input type="number" class="form-control" id="u_age" name="u_age" required>
        </div>
        <div class="mb-3">
            <label for="u_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="u_username" name="u_username" required>
        </div>
        <div class="mb-3">
            <label for="u_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="u_password" name="u_password" required>
        </div>
        <div class="mb-3">
            <label for="u_confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="u_confirm_password" name="u_confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="signup">Signup</button>
        <a href="login.php" class="btn btn-link">Already have an account? Login here</a>
    </form>
</div>
</body>
</html>
