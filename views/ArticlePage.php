<?php
require_once __DIR__ . '/../models/ArticleModel.php';

$model = new ArticleModel();
$articles = $model->getAllArticles();
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
    <div class="container py-4">
        <h2 class="text-center mb-4">Danh sách bài viết</h2>
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <?php if (!empty($article['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($article['image_url']); ?>" class="card-img-top" alt="Ảnh bài viết">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                            <p class="card-text">
                                <?php
                                $preview = strip_tags($article['content']);
                                echo strlen($preview) > 100 ? substr($preview, 0, 100) . '...' : $preview;
                                ?>
                            </p>
                        </div>
                        <div class="card-footer text-end">
                            <a href="ArticleDetail.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-primary">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
