<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aroma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Change Bootstrap primary color to #154466 */
        .btn-primary, .text-primary, .bg-primary, .navbar-light .navbar-nav .nav-link.active,
        .navbar-light .navbar-nav .nav-link:focus, .navbar-light .navbar-nav .nav-link:hover {
            color: #ffffff !important;
            background-color: #154466 !important;
            border-color: #154466 !important;
        }

        /* Optional: change outline button for consistency */
        .btn-outline-primary {
            color: #154466 !important;
            border-color: #154466 !important;
        }
        .btn-outline-primary:hover {
            background-color: #154466 !important;
            color: #ffffff !important;
        }
    </style>
</head>
<body>
    <?php include("components/navbar.php"); ?>

    <!-- Content -->
    <div class = 'container-fluid'>
        <img src = 'images/homebanner.png'  alt="home banner" class="img-fluid"/>
    </div>

</body>
</html>