<?php
require_once __DIR__ . '/../models/ArticleModel.php';

// Lấy ID từ URL
$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($articleId <= 0) {
    die('ID bài viết không hợp lệ.');
}

$model = new ArticleModel();
$article = $model->getArticleById($articleId);

if (!$article) {
    die('Không tìm thấy bài viết.');
}
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
<main class="main-content">
   
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <article class="card shadow">
                <?php if (!empty($article['image_url'])): ?>
                    <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="Hình ảnh" class="img-fluid rounded mb-3">
                <?php endif; ?>

                <div class="card-body">
                    <h1 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h1>
                    <p class="card-text">
                        <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                    </p>
                </div>
                <div class="card-footer text-end">
                    <a href="ArticlePage.php" class="btn btn-secondary">← Quay lại danh sách</a>
                </div>
            </article>
        </div>
    </div>
</div>
</main>
<div>
    <?php include('../includes/Footer.php'); ?>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
