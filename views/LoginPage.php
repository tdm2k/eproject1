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
    <title>Space Dot Com | Login</title>

    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">

    <style>
        body {
            background-image: url('../../assets/images/background-login.jpg');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;

            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px);
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .login-form-wrapper h2 {
            margin-bottom: 25px;
            text-align: center;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }

        /* --- Responsive đơn giản --- */
        @media (max-width: 767.98px) {
            .login-form-wrapper {
                padding: 25px;
                max-width: 90%;
            }

            .login-container {
                padding: 15px;
            }
        }

        @media (max-width: 575.98px) {
            .login-form-wrapper {
                padding: 20px;
            }

            .login-form-wrapper h2 {
                font-size: 1.5rem;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>

    <div>
        <?php
        include('../includes/Header.php');
        ?>
    </div>

    <div class="container login-container">
        <div class="login-form-wrapper">
            <h2>Login</h2>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i> Invalid username or password!
                </div>
            <?php endif; ?>

            <?php
            $successMessages = [
                'registered' => 'User registered successfully! Please login.',
                'password_reset' => 'Password reset successfully! Please login.'
            ];

            if (isset($_GET['success']) && isset($successMessages[$_GET['success']])): ?>
                <div class="alert alert-success success-notification show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= $successMessages[$_GET['success']] ?>
                </div>
            <?php endif; ?>

            <form action="../../controllers/UserController.php?action=login" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username or Email</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <div class="mt-3 text-center">
                    <p>Don't have an account? <a href="RegisterPage.php">Register now!</a></p>
                    <p>Forgot your password? <a href="ResetPasswordPage.php">Recover here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
</body>

</html>