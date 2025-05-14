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
    <link rel="stylesheet" href="assets/css/simple-notification.css">
</head>

<body>
    <!-- Header -->
    <div>
        <?php include('includes/Header.php'); ?>
    </div>

    <!-- Page Content -->
    <div class="container" style="margin-top: 6%">

        <!-- Success Notification -->
        <?php if (isset($_GET['status']) && $_GET['status'] === 'logged_out'): ?>
            <div class="alert alert-success success-notification show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Logged out successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'password_reset_link_sent'): ?>
            <div class="alert alert-success success-notification show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Password reset request sent successfully! Please check your email.
            </div>
        <?php endif; ?>

        <!-- Error Notification -->
        <?php if (isset($_GET['error'])):
            $error = $_GET['error']; ?>
            <div class="alert alert-danger error-notification show" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <p>Welcome</p>
        <?php include('moon-animation.html'); ?>

        <!-- Catalogue -->
        <?php //include('includes/Catalogue.html'); 
        ?>
    </div>

    <!-- Footer -->
    <div>
        <?php include('includes/Footer.php'); ?>
    </div>

    <!-- Bootstrap -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/simple-notification.js"></script>
</body>

</html>