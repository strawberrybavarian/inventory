<?php
session_start();
include("dbconnection.php");

if (isset($_POST['login'])) {
    $u_username = mysqli_real_escape_string($dbconnect, $_POST['u_username']);
    $u_password = mysqli_real_escape_string($dbconnect, $_POST['u_password']);

    $query = "SELECT * FROM users WHERE u_username = '$u_username' AND u_password = '$u_password'";
    $result = mysqli_query($dbconnect, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['u_id'] = $user['u_id'];
        $_SESSION['u_firstname'] = $user['u_firstname'];

        header("Location: inventory.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Login</h1>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php } ?>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="u_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="u_username" name="u_username" required>
        </div>
        <div class="mb-3">
            <label for="u_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="u_password" name="u_password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button>
        <a href="signup.php" class="btn btn-link">Don't have an account? Signup here</a>
    </form>
</div>
</body>
</html>
