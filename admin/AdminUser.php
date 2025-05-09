<?php
require_once '../models/UserModel.php';
require_once '../entities/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
    }
}
$userModel = new UserModel();
$users = $userModel->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin</title>
    <!-- Bootstrap -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .main-page-content {
            margin-left: 280px;
        }

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

        .error-notification {
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

        .error-notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        .action-column {
            text-align: right;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4">
            <div class="container mt-5">
                <h2 class="mb-4">Users</h2>

                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] === 'password-updated'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Password changed successfully!
                        </div>
                    <?php elseif ($_GET['status'] === 'user-updated'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> User profile updated successfully!
                        </div>
                    <?php elseif ($_GET['status'] === 'user-deleted'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> User deleted successfully!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (isset($_GET['error'])):
                    $error = $_GET['error']; ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="action-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user->getId() ?></td>
                                <td><?= htmlspecialchars($user->getUsername()) ?></td>
                                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                                <td><?= $user->getRole() ?></td>
                                <td class="action-column">
                                    <a href="#" class="btn btn-sm btn-warning edit-user-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-user-id="<?= $user->getId() ?>"
                                        data-user-username="<?= htmlspecialchars($user->getUsername()) ?>"
                                        data-user-email="<?= htmlspecialchars($user->getEmail()) ?>"
                                        data-user-fullname="<?= htmlspecialchars($user->getFullname() ?? '') ?>"
                                        data-user-phone="<?= htmlspecialchars($user->getPhone() ?? '') ?>"
                                        data-user-role="<?= $user->getRole() ?>"
                                        data-user-dob="<?= $user->getDob() ? $user->getDob()->format('Y-m-d') : '' ?>"
                                        data-user-gender="<?= $user->getGender() ?>">
                                        <i class="bi bi-pencil-fill me-2"></i> Edit Profile
                                    </a>
                                    <a href="#" class="btn btn-sm btn-warning change-password-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#changePasswordModal"
                                        data-user-id="<?= $user->getId() ?>">
                                        <i class="bi bi-key-fill me-2"></i> Change Password
                                    </a>
                                    <a href="../controllers/UserController.php?action=delete&id=<?= $user->getId() ?>" class="btn btn-sm btn-danger" onclick="return confirm('Do you really want to delete this user?');">
                                        <i class="bi bi-trash-fill me-2"></i> Delete
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <div>
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </div>
    </div>


    <!-- Modal Edit User Profile -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Update User Information</h5>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" action="../controllers/UserController.php?action=update" method="POST">
                        <input type="hidden" name="id" id="editFormId">
                        <div class="mb-3">
                            <label for="editFormRole" class="form-label">Role</label>
                            <select class="form-select" id="editFormRole" name="role">
                                <option value="admin">Admin</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editFormUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editFormUsername" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="editFormEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editFormEmail" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="editFormFullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editFormFullname" name="fullname">
                        </div>
                        <div class="mb-3">
                            <label for="editFormPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="editFormPhone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="editFormDob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="editFormDob" name="dob">
                        </div>
                        <div class="mb-3">
                            <label for="editFormGender" class="form-label">Gender</label>
                            <select class="form-select" id="editFormGender" name="gender">
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                                <option value="2">Other</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="editUserForm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Change Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="../controllers/UserController.php?action=change-password" method="POST">
                        <input type="hidden" name="id" id="changePasswordFormId">
                        <div class="mb-3">
                            <label for="changePasswordFormOldPassword" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="changePasswordFormOldPassword" name="old_password">
                        </div>
                        <div class="mb-3">
                            <label for="changePasswordFormPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="changePasswordFormPassword" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="changePasswordFormConfirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="changePasswordFormConfirmPassword" name="confirm_password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="changePasswordForm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-user-btn').click(function() {
                var userId = $(this).data('user-id');
                var username = $(this).data('user-username');
                var email = $(this).data('user-email');
                var fullname = $(this).data('user-fullname');
                var phone = $(this).data('user-phone');
                var role = $(this).data('user-role');
                var dob = $(this).data('user-dob');
                var gender = $(this).data('user-gender');

                $('#editFormId').val(userId);
                $('#editFormUsername').val(username);
                $('#editFormEmail').val(email);
                $('#editFormFullname').val(fullname);
                $('#editFormPhone').val(phone);
                $('#editFormRole').val(role);
                $('#editFormDob').val(dob);
                $('#editFormGender').val(gender);
            });

            $('.change-password-btn').click(function() {
                var userId = $(this).data('user-id');
                $('#changePasswordFormId').val(userId);
            });
        });

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

        document.addEventListener('DOMContentLoaded', function() {
            const errorNotification = document.querySelector('.error-notification');
            if (errorNotification) {
                setTimeout(function() {
                    errorNotification.classList.add('show');
                    setTimeout(function() {
                        errorNotification.classList.remove('show');
                    }, 3000); // 3 giây
                }, 100);
            }
        });
    </script>
</body>

</html>