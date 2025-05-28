<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../models/UserModel.php';
require_once '../models/PasswordResetModel.php';
require_once '../entities/User.php';

$userModel = new UserModel();
$resetPasswordModel = new PasswordResetModel();

$action = $_GET['action'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'login':
            handleLogin($userModel);
            break;
        case 'register':
            handleRegister($userModel);
            break;
        case 'update':
            handleUpdate($userModel);
            break;
        case 'user_update':
            handleUserUpdate($userModel);
            break;
        case 'delete':
            handleDelete($userModel);
            break;
        case 'change_password':
            handleChangePassword($userModel);
            break;
        case 'user_change_password':
            handleUserChangePassword($userModel);
            break;
        case 'request_password':
            handleRequestPassword($resetPasswordModel, $userModel);
            break;
        case 'reset_password':
            handleResetPassword($resetPasswordModel, $userModel);
            break;
        default:
            header('Location: ../views/LoginPage.php');
            exit;
    }
} else {
    switch ($action) {
        case 'logout':
            handleLogout();
            break;
        case 'delete':
            handleDelete($userModel);
            break;
        default:
            header('Location: ../views/LoginPage.php');
            exit;
    }
}

// --- Update ---
function handleUpdate(UserModel $userModel)
{
    $userId = $_POST['id'];

    if ($userId) {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $dobString = $_POST['dob'] ?? null;
        $gender = $_POST['gender'] ?? null;

        $errors = [];
        if (empty($username)) {
            $errors[] = 'Username cannot be empty.';
        }
        if (empty($email)) {
            $errors[] = 'Email cannot be empty.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        $existingUser = $userModel->findUserById($userId);
        if (!$existingUser) {
            $errors[] = 'User not found.';
        }

        $dob = null;
        if (!empty($dobString)) {
            try {
                $dob = new DateTime($dobString);
            } catch (Exception $e) {
                $errors[] = 'Invalid date of birth format.';
            }
        }

        if (!empty($errors)) {
            $error_param = urlencode($errors[0]);
            header("Location: ../admin/AdminUser.php?error=$error_param");
            exit;
        }

        $genderInt = null;
        if ($gender !== null) {
            $genderInt = (int) $gender;
        }

        $updatedUser = new User(
            $existingUser->getPasswordHash(),
            $username,
            $email,
            $fullname,
            $phone,
            $role,
            $dob,
            $genderInt,
            $userId
        );

        $success = $userModel->updateUser($updatedUser);

        if ($success) {
            header('Location: ../admin/AdminUser.php?action=userList&status=user_updated');
            exit;
        } else {
            header('Location: ../admin/AdminUser.php?action=userList&error=user_not_updated');
            exit;
        }
    } else {
        header('Location: ../admin/AdminUser.php?action=userList&error=invalid_user_id');
        exit;
    }
}

// --- User Update ---
function handleUserUpdate(UserModel $userModel)
{
    $userId = $_POST['id'];

    if ($userId) {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $dobString = $_POST['dob'] ?? null;
        $gender = $_POST['gender'] ?? null;

        $errors = [];
        if (empty($username)) {
            $errors[] = 'Username cannot be empty.';
        }
        if (empty($email)) {
            $errors[] = 'Email cannot be empty.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        $existingUser = $userModel->findUserById($userId);
        if (!$existingUser) {
            $errors[] = 'User not found.';
        }

        $dob = null;
        if (!empty($dobString)) {
            try {
                $dob = new DateTime($dobString);
            } catch (Exception $e) {
                $errors[] = 'Invalid date of birth format.';
            }
        }

        if (!empty($errors)) {
            $error_param = urlencode($errors[0]);
            header("Location: ../views/UserProfilePage.php?error=$error_param");
            exit;
        }

        $genderInt = null;
        if ($gender !== null) {
            $genderInt = (int) $gender;
        }

        $updatedUser = new User(
            $existingUser->getPasswordHash(),
            $username,
            $email,
            $fullname,
            $phone,
            $role,
            $dob,
            $genderInt,
            $userId
        );

        $success = $userModel->updateUser($updatedUser);

        if ($success) {
            header('Location: ../index.php?success=user_updated');
            exit;
        } else {
            header('Location: ../views/UserProfilePage.php?action=userList&error=user_not_updated');
            exit;
        }
    } else {
        header('Location: ../views/UserProfilePage.php?action=userList&error=invalid_user_id');
        exit;
    }
}

// --- Delete ---
function handleDelete(UserModel $userModel)
{
    $userId = $_GET['id'] ?? $_POST['id'] ?? null;

    if ($userId) {
        $success = $userModel->deleteUser($userId);

        if ($success) {
            header('Location: ../admin/AdminUser.php?action=userList&status=user_deleted');
            exit;
        } else {
            header('Location: ../admin/AdminUser.php?action=userList&error=user_not_deleted');
            exit;
        }
    } else {
        header('Location: ../admin/AdminUser.php?action=userList&error=invalid_user_id');
        exit;
    }
}

// --- Change Password ---
function handleChangePassword(UserModel $userModel)
{
    $userId = $_POST['id'];
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $errors = [];
    if (!$userId) {
        $errors[] = 'User ID is required.';
    }

    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $errors[] = 'All fields are required.';
    }

    if ($newPassword !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    $user = $userModel->findUserById($userId);

    if (!$user) {
        $errors[] = 'User not found.';
    }

    if (!password_verify($oldPassword, $user->getPasswordHash())) {
        $errors[] = 'Old password is incorrect.';
    }

    if (!empty($errors)) {
        $error_param = urlencode($errors[0]);
        header("Location: ../admin/AdminUser.php?error=$error_param");
        exit;
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $success = $userModel->changePassword($userId, $newPasswordHash);

    if ($success) {
        header('Location: ../admin/AdminUser.php?action=userList&status=password_updated');
        exit;
    } else {
        header('Location: ../admin/AdminUser.php?action=userList&error=password_not_updated');
        exit;
    }
}

// --- User Change Password ---
function handleUserChangePassword(UserModel $userModel)
{
    $userId = $_POST['id'];
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $errors = [];
    if (!$userId) {
        $errors[] = 'User ID is required.';
    }

    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $errors[] = 'All fields are required.';
    }

    if ($newPassword !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    $user = $userModel->findUserById($userId);

    if (!$user) {
        $errors[] = 'User not found.';
    }

    if (!password_verify($oldPassword, $user->getPasswordHash())) {
        $errors[] = 'Old password is incorrect.';
    }

    if (!empty($errors)) {
        $error_param = urlencode($errors[0]);
        header("Location: ../views/ChangePasswordPage.php?error=$error_param");
        exit;
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $success = $userModel->changePassword($userId, $newPasswordHash);

    if ($success) {
        header('Location: ../index.php?success=password_updated');
        exit;
    } else {
        header('Location: ../index.php?error=password_not_updated');
        exit;
    }
}

// --- Login ---
function handleLogin(UserModel $userModel)
{
    $identifier = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($identifier) || empty($password)) {
        header('Location: ../views/LoginPage.php?error=empty_fields');
        exit;
    }

    $user = $userModel->findUserByIdentifier($identifier);

    if ($user && password_verify($password, $user->getPasswordHash())) {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['user_role'] = $user->getRole();
        $_SESSION['user_fullname'] = $user->getFullname();

        if ($user->getRole() === 'admin') {
            header('Location: ../admin/Dashboard.php');
            exit;
        } else {
            header('Location: ../index.php');
            exit;
        }
    } else {
        header('Location: ../views/LoginPage.php?error=invalid_credentials');
        exit;
    }
}

// --- Register ---
function handleRegister(UserModel $userModel)
{
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dob_string = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';

    // --- Validation ---
    $errors = [];
    if (empty($username)) $errors[] = 'Username is required.';
    if (empty($password)) $errors[] = 'Password is required.';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (empty($fullname)) $errors[] = 'Full name is required.';
    if (empty($dob_string)) $errors[] = 'Date of birth is required.';
    if (empty($gender)) $errors[] = 'Gender is required.';

    if (empty($errors)) {
        if ($userModel->findUserByUsername($username)) {
            $errors[] = 'Username already exists.';
        }
        if ($userModel->findUserByEmail($email)) {
            $errors[] = 'Email already exists.';
        }
    }

    if (!empty($errors)) {
        $error_param = urlencode($errors[0]);
        header("Location: ../views/RegisterPage.php?error=$error_param");
        exit;
    }

    // --- Xử lý dữ liệu ---
    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $gender_int = null;
    if ($gender === 'male') {
        $gender_int = 0;
    } elseif ($gender === 'female') {
        $gender_int = 1;
    } elseif ($gender === 'other') {
        $gender_int = 2;
    }

    try {
        $dob_datetime = !empty($dob_string) ? new DateTime($dob_string) : null;
    } catch (Exception $e) {
        header("Location: ../views/RegisterPage.php?error=invalid_dob_format");
        exit;
    }

    try {
        $newUser = new User(
            $password_hash,
            $username,
            $email,
            $fullname,
            $phone ?: null,
            'customer',
            $dob_datetime,
            $gender_int
        );
    } catch (TypeError $e) {
        error_log("User object creation type error: " . $e->getMessage());
        header('Location: ../views/RegisterPage.php?error=internal_error');
        exit;
    }

    try {
        $success = $userModel->createUser($newUser);

        if ($success) {
            header('Location: ../views/LoginPage.php?success=registered');
            exit;
        } else {
            header('Location: ../views/RegisterPage.php?error=registration_failed');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: ../views/RegisterPage.php?error=db_error');
        exit;
    }
}

// --- Logout ---
function handleLogout()
{
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();

    header('Location: ../index.php?status=logged_out');
    exit;
}

// --- Reset Password ---
function handleResetPassword(PasswordResetModel $resetPasswordModel, UserModel $userModel)
{
    $token = $_POST['token'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($token) || empty($newPassword) || empty($confirmPassword)) {
        header('Location: ../views/ResetPasswordPage.php?token=' . $token . '&error=empty_fields');
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        header('Location: ../views/ResetPasswordPage.php?token=' . $token . '&error=passwords_do_not_match');
        exit;
    }

    $resetRequest = $resetPasswordModel->findPasswordResetByToken($token);

    if (!$resetRequest || strtotime($resetRequest['expired_at']) < time()) {
        var_dump($token);
        var_dump(strtotime($resetRequest['expired_at']));
        var_dump(time());
        exit;
        header('Location: ../views/ResetPasswordPage.php?token=' . $token . '&error=invalid_or_expired_token');
        exit;
    }

    $user = $userModel->findUserByEmail($resetRequest['email']);
    if (!$user) {
        header('Location: ../views/ResetPasswordPage.php?token=' . $token . '&error=user_not_found');
        exit;
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $success = $userModel->changePassword($user->getId(), $newPasswordHash);

    if ($success) {
        $resetPasswordModel->deletePasswordResetToken($resetRequest['email']);
        header('Location: ../views/LoginPage.php?success=password_reset');
        exit;
    } else {
        header('Location: ../views/ResetPasswordPage.php?token=' . $token . '&error=password_reset_failed');
        exit;
    }
}

// --- Request Reset Password ---
function handleRequestPassword(PasswordResetModel $resetPasswordModel, UserModel $userModel)
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $resetPasswordModel->deleteExpiredTokens();

    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        header('Location: ../views/ResetPasswordPage.php?error=empty_email');
        exit;
    }

    $user = $userModel->findUserByEmail($email);

    if (!$user) {
        header('Location: ../views/ResetPasswordPage.php?error=email_not_found');
        exit;
    }

    // Xoá token cũ (nếu có)
    $resetPasswordModel->deletePasswordResetToken($email);

    // Tạo token mới
    $token = bin2hex(random_bytes(32)); // 64 ký tự
    $expires = date("Y-m-d H:i:s", strtotime("+15 minutes"));

    $success = $resetPasswordModel->createPasswordResetToken($email, $token, $expires);
    if (!$success) {
        header('Location: ../views/ResetPasswordPage.php?error=token_creation_failed');
        exit;
    }

    $resetLink = "localhost:3000/views/ResetPasswordPage.php?token=" . urlencode($token);
    $subject = "Password Reset Request";
    $message = "You requested to reset your password. Click the link below:\n\n$resetLink\n\n"
        . "If you did not request this, please ignore this email.";
    $headers = "From: no-reply@space.com\r\n";

    // Lưu thông tin "email" vào file txt
    $file = '../reset_password_emails.txt';
    $timestamp = date("Y-m-d H:i:s");
    $emailContent = "[{$timestamp}] To: {$email}\nSubject: {$subject}\n\n{$message}\n{$headers}\n\n--------------------\n";
    file_put_contents($file, $emailContent, FILE_APPEND | LOCK_EX);

    header('Location: ../index.php?success=password_reset_link_sent');
    exit;
}
