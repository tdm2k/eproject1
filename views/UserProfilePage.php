<?php
require_once '../models/UserModel.php';
require_once '../entities/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userModel = new UserModel();
$user = $userModel->findUserById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | User Profile</title>

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
            padding-top: 100px;
        }

        .request-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 56px);
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

    <div class="container request-container">
        <div class="request-form-wrapper">
            <h2>Change User Profile</h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger error-notification show" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form action="../controllers/UserController.php?action=user_update" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId()) ?>" required>
                <div class="mb-3">
                    <label for="editFormUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="editFormUsername" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>">
                </div>
                <div class="mb-3">
                    <label for="editFormEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editFormEmail" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>">
                </div>
                <div class="mb-3">
                    <label for="editFormFullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="editFormFullname" name="fullname" value="<?= htmlspecialchars($user->getFullname()) ?>">
                </div>
                <div class="mb-3">
                    <label for="editFormPhone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="editFormPhone" name="phone" value="<?= htmlspecialchars($user->getPhone()) ?>">
                </div>
                <div class="mb-3">
                    <label for="editFormDob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="editFormDob" name="dob" value="<?= $user->getDob() instanceof DateTime ? htmlspecialchars($user->getDob()->format('Y-m-d')) : '' ?>">
                </div>
                <div class="mb-3">
                    <label for="editFormGender" class="form-label">Gender</label>
                    <select class="form-select" id="editFormGender" name="gender">
                        <option value="0" <?= ($user->getGender() === 0) ? 'selected' : '' ?>>Male</option>
                        <option value="1" <?= ($user->getGender() === 1) ? 'selected' : '' ?>>Female</option>
                        <option value="2" <?= ($user->getGender() === 2) ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            </form>
        </div>
    </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
</body>

</html>