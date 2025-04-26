<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Home Page</title>
    <!-- Bootstrap -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Header -->
    <div>
        <?php include('includes/Header.php'); ?>
    </div>


    <!-- Page Content -->
    <div class="container" style="margin-top: 6%">
        <p>Welcome</p>
    </div>

    <!-- Footer -->
    <div>
        <?php include('includes/Footer.php'); ?>
    </div>

    <!-- Bootstrap -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>