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

    <style>
        .success-notification {
            position: fixed;
            top: auto;
            bottom: 20px;
            left: auto;
            right: 20px;
            z-index: 1055;
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .success-notification.show {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div>
        <?php include('includes/Header.php'); ?>
    </div>

    <!-- Page Content -->
    <div class="container" style="margin-top: 6%">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'logged-out'): ?>
            <div class="alert alert-success success-notification show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Logged out successfully!
            </div>
        <?php endif; ?>
        <p>Welcome</p>
    </div>

    <!-- Footer -->
    <div>
        <?php include('includes/Footer.php'); ?>
    </div>

    <!-- Bootstrap -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successNotification = document.querySelector('.success-notification');
            if (successNotification) {
                setTimeout(function() {
                    successNotification.classList.add('show');
                    setTimeout(function() {
                        successNotification.classList.remove('show');
                    }, 3000); // 3 giây
                }, 100);
            }
        });
    </script>
</body>

</html>