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
    <title>Space Dot Com | Register</title>

    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
        }

        .main-content-area {
            display: flex;
            flex-grow: 1;
        }

        .image-section {
            background-image: url('../../assets/images/background-register.jpg');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            width: 60%;
        }

        .form-section {
            width: 40%;
            display: flex;
            justify-content: center;
            padding: 40px;
            background-color: #f8f9fa;

            overflow-y: auto;
        }


        .registration-form {
            width: 100%;
            max-width: 480px;
        }

        .registration-form h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #333;
            font-weight: 600;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }

        .gender-options .form-check {
            display: inline-block;
            margin-right: 15px;
        }

        .form-label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        /* --- Responsive đơn giản --- */
        @media (max-width: 991.98px) {

            body,
            html {
                height: auto;
            }

            .main-content-area {
                flex-direction: column;
            }

            .image-section {
                display: none;
            }

            .form-section {
                width: 100%;
                padding: 25px;
            }

            .registration-form {
                max-width: none;
            }
        }
    </style>
</head>

<body>

    <?php include('../includes/Header.php'); ?>

    <div class="main-content-area">
        <div class="image-section">
        </div>

        <div class="form-section">
            <form class="registration-form" action="../../controllers/UserController.php?action=register" method="post">
                <h2>Create Account</h2>

                <div class="mb-3">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col">
                        <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Optional">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Gender <span class="text-danger">*</span></label>
                        <div class="gender-options mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="other" value="other" required>
                                <label class="form-check-label" for="other">Other</label>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_GET['error'])):
                    $error = $_GET['error'];
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>

                <div class="mt-4 text-center">
                    <p>Already have an account? <a href="LoginPage.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const form = document.querySelector('.registration-form');

        form.addEventListener('submit', function(event) {
            if (password.value !== confirmPassword.value) {
                alert('Passwords do not match!');
                confirmPassword.focus();
                event.preventDefault(); // Stop form submission
            }
        });
    </script>

</body>

</html>