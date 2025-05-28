<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
        exit();
    }
}

require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../controllers/ConstellationController.php';

// Khởi tạo kết nối
$connObj = new Connection();
$conn = $connObj->getConnection();

$controller = new ConstellationController($conn);
$controller->handleAdminRequest();
$constellations = $controller->getAllConstellations();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Space Dot Com | Admin</title>
    <!-- Bootstrap -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <style>
        .main-page-content {
            margin-left: 280px;
        }
    </style>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <main class="flex-grow-1 p-4">
            <h2>Trang quản trị chòm sao</h2>

            <!-- Form Thêm mới -->
            <form method="post" class="mb-4">
                <input
                    class="form-control mb-2"
                    type="text"
                    name="name"
                    placeholder="Tên chòm sao"
                    required
                />
                <textarea
                    class="form-control mb-2"
                    name="description"
                    placeholder="Mô tả"
                    required
                ></textarea>
                <button class="btn btn-primary" type="submit" name="add">Thêm</button>
            </form>

            <h3>Danh sách</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($constellations as $c): ?>
                        <tr>
                            <form method="post">
                                <td>
                                    <?= $c->getId() ?>
                                    <input type="hidden" name="id" value="<?= $c->getId() ?>" />
                                </td>
                                <td>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="name"
                                        value="<?= htmlspecialchars($c->getName()) ?>"
                                        required
                                    />
                                </td>
                                <td>
                                    <textarea
                                        class="form-control"
                                        name="description"
                                        required
                                    ><?= htmlspecialchars($c->getDescription()) ?></textarea>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" type="submit" name="update">Sửa</button>
                                    <button
                                        class="btn btn-danger btn-sm"
                                        type="submit"
                                        name="delete"
                                        onclick="return confirm('Xóa?')"
                                    >
                                        Xóa
                                    </button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>

        <!-- Footer -->
        <footer class="mt-auto">
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </footer>
    </div>

    <!-- Bootstrap -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
