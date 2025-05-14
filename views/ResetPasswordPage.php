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
    <title>Space Dot Com | Reset Password</title>

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

        .request-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px);
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .request-form-wrapper {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .request-form-wrapper h2 {
            margin-bottom: 25px;
            text-align: center;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }

        /* --- Responsive đơn giản --- */
        @media (max-width: 767.98px) {
            .request-form-wrapper {
                padding: 25px;
                max-width: 90%;
            }

            .request-container {
                padding: 15px;
            }
        }

        @media (max-width: 575.98px) {
            .request-form-wrapper {
                padding: 20px;
            }

            .request-form-wrapper h2 {
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

    <?php if (isset($_GET['token'])): ?>
        <!-- FORM ĐẶT LẠI MẬT KHẨU -->
        <div class="container request-container">
            <div class="request-form-wrapper">
                <h2>Reset Your Password</h2>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="../../controllers/UserController.php?action=reset_password" method="post">
                    <!-- Hidden input chứa token -->
                    <input type="hidden" id="token" name="token" value="<?= htmlspecialchars($_GET['token']) ?>">

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <!-- FORM YÊU CẦU RESET MẬT KHẨU -->
        <div class="container request-container">
            <div class="request-form-wrapper">
                <h2>Request Password Reset</h2>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="../../controllers/UserController.php?action=request_password" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
</body>

</html>