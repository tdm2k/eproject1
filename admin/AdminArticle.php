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

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$totalArticles = $model->getTotalArticles();
$totalPages = ceil($totalArticles / $limit);
$articles = $model->getAllArticlesPaginated($limit, $offset);

$article = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $article = $model->getArticleById($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Space Dot Com | Admin</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .main-page-content { margin-left: 280px; }
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="main-page-content d-flex flex-column min-vh-100">
    <?php include '../admin/includes/AdminSidebar.php'; ?>

    <main class="flex-grow-1 p-4">
        <h2>Article Management</h2>

        <?php if ($action === 'add' || $action === 'edit'): ?>
            <a href="AdminArticle.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Back to List</a>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($action === 'edit' && isset($_GET['id'])): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($article['title'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="6" required><?= htmlspecialchars($article['content'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image_file" class="form-label">Image</label>
                    <input type="file" name="image_file" id="image_file" class="form-control">
                    <?php if (!empty($article['image_url'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($article['image_url']) ?>" class="mt-2" width="150">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save Article</button>
            </form>
        <?php else: ?>
            <a href="AdminArticle.php?action=add" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Add Article</a>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr><th>ID</th><th>Title</th><th>Image</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= $article['id'] ?></td>
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td>
                            <?php if (!empty($article['image_url'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($article['image_url']) ?>" width="100">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="AdminArticle.php?action=edit&id=<?= $article['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                            <a href="AdminArticle.php?action=delete&id=<?= $article['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?');"><i class="bi bi-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($totalPages > 1): ?>
                <div class="pagination-wrapper">
                    <nav>
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="bi bi-chevron-left"></i></a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="bi bi-chevron-right"></i></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer class="mt-auto"><?php include('../admin/includes/AdminFooter.php'); ?></footer>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
