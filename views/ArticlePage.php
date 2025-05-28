<?php
require_once '../models/ArticleModel.php';
require_once '../controllers/ArticleController.php';

$model = new ArticleModel();
$controller = new ArticleController();

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $controller->handleRequest('add', $_POST);
        exit;
    } elseif ($action === 'edit' && $id) {
        $_POST['id'] = $id;
        $controller->handleRequest('edit', $_POST);
        exit;
    }
} elseif ($action === 'delete' && $id) {
    $controller->handleRequest('delete', ['id' => $id]);
    exit;
}

$articles = $model->getAllArticles();
$article = $id ? $model->getArticleById($id) : null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Space Dot Com | Bài viết</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .article-card { margin-bottom: 30px; }
        .article-content { white-space: pre-line; }
    </style>
</head>
<body>
<div>
    <?php include('../includes/Header.php'); ?>
</div>

<div class="container" style="margin-top: 6%">
    <?php if ($action === 'add'): ?>
        <div class="mb-4">
            <a href="ArticlePage.php" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left-circle"></i> Quay lại
            </a>
            <h3>Thêm bài viết</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Thêm bài</button>
            </form>
        </div>

    <?php elseif ($action === 'edit' && $article): ?>
        <div class="mb-4">
            <a href="ArticlePage.php" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left-circle"></i> Quay lại
            </a>
            <h3>Sửa bài viết</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content" rows="6" required><?= htmlspecialchars($article['content']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
            </form>
        </div>

    <?php elseif ($article): ?>
        <div class="mb-4">
            <a href="ArticlePage.php" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left-circle"></i> Quay lại
            </a>
            <h2><?= htmlspecialchars($article['title']) ?></h2>
            <hr>
            <div class="article-content"><?= nl2br(htmlspecialchars($article['content'])) ?></div>
        </div>

    <?php else: ?>
        <h3 class="mb-4">Bài viết mới nhất</h3>
        <div class="row">
            <?php foreach ($articles as $a): ?>
                <div class="col-md-6 article-card">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($a['title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars(substr($a['content'], 0, 200))) ?>...</p>
                            <a href="?id=<?= $a['id'] ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-book"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div>
    <?php include('../includes/Footer.php'); ?>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
