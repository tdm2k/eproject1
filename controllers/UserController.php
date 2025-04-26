<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../models/UserModel.php';
require_once '../entities/User.php';

$action = $_GET['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userModel = new UserModel(); // Khởi tạo model

    switch ($action) {
        case 'login':
            handleLogin($userModel);
            break;

        case 'register':
            handleRegister($userModel);
            break;

        default:
            echo "Invalid action requested.";
            exit;
    }
} else {
    if ($action === 'logout') {
        handleLogout();
    } else {

        header('Location: ../views/LoginPage.php');
        exit;
    }
}

// --- Hàm xử lý Login ---
function handleLogin(UserModel $userModel)
{
    $identifier = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation cơ bản
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

// --- Hàm xử lý Register ---
function handleRegister(UserModel $userModel)
{
    // Lấy dữ liệu từ POST
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $phone = trim($_POST['phone'] ?? ''); // Optional
    $dob_string = $_POST['dob'] ?? ''; // Date string
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
    // Thêm các validation khác nếu cần (độ dài pass, username tồn tại, email tồn tại...)

    // Kiểm tra username hoặc email đã tồn tại chưa
    if (empty($errors)) {
        if ($userModel->findUserByUsername($username)) {
            $errors[] = 'Username already exists.';
        }
        if ($userModel->findUserByEmail($email)) {
            $errors[] = 'Email already exists.';
        }
    }

    // Nếu có lỗi validation -> Quay lại trang đăng ký với thông báo
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
        $gender_int = 0; // Giả sử 0 là nam
    } elseif ($gender === 'female') {
        $gender_int = 1; // Giả sử 1 là nữ
    } elseif ($gender === 'other') {
        $gender_int = 2; // Giả sử 2 là khác
    }

    try {
        // Chỉ tạo DateTime nếu $dob_string không rỗng
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

// --- Hàm xử lý Logout ---
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
