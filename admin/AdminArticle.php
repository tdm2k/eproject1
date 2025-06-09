<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
        exit;
    }
}

require_once '../controllers/ArticleController.php';
require_once '../models/ArticleModel.php';

$model = new ArticleModel();
$controller = new ArticleController($model);
$action = $_GET['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $controller->handleRequest($action, $data);
    exit;
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $controller->handleRequest('delete', ['id' => $_GET['id']]);
    exit;
}

$articles = $model->getAllArticles();
$article = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $article = $model->getArticleById($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Space Dot Com | Admin</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>.main-page-content { margin-left: 280px; }</style>
</head>
<body>
<div class="main-page-content d-flex flex-column min-vh-100">
    <?php include '../admin/includes/AdminSidebar.php'; ?>

    <main class="flex-grow-1 p-4">
        <h2>Quản lý bài viết</h2>

        <?php if ($action === 'add' || $action === 'edit'): ?>
            <a href="AdminArticle.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($article['title'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea name="content" id="content" class="form-control" rows="6" required><?= htmlspecialchars($article['content'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">Đường dẫn ảnh minh họa</label>
                    <input type="text" name="image_url" id="image_url" class="form-control" placeholder="Ví dụ: https://example.com/image.jpg hoặc images/photo.jpg" value="<?= htmlspecialchars($article['image_url'] ?? '') ?>">
                    <?php if (!empty($article['image_url'])): ?>
                        <img src="<?= htmlspecialchars($article['image_url']) ?>" class="mt-2" width="150">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Lưu bài viết</button>
            </form>
        <?php else: ?>
            <a href="AdminArticle.php?action=add" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Thêm bài viết</a>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr><th>ID</th><th>Tiêu đề</th><th>Hình ảnh</th><th>Hành động</th></tr>
                </thead>
                <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= $article['id'] ?></td>
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td>
                            <?php if (!empty($article['image_url'])): ?>
                                <img src="<?= htmlspecialchars($article['image_url']) ?>" width="100">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="AdminArticle.php?action=edit&id=<?= $article['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Sửa</a>
                            <a href="AdminArticle.php?action=delete&id=<?= $article['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá?');"><i class="bi bi-trash"></i> Xoá</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
    <footer class="mt-auto"><?php include('../admin/includes/AdminFooter.php'); ?></footer>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
