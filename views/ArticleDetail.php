<?php
require_once __DIR__ . '/../models/ArticleModel.php';

$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($articleId <= 0) die('Invalid article ID.');

$model = new ArticleModel();
$article = $model->getArticleById($articleId);
if (!$article) die('Article not found.');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Space Dot Com | <?= htmlspecialchars($article['title']) ?></title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            padding-top: 76px;
        }  
        .article-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }
        .article-image:hover {
            transform: scale(1.02);
        }
        .article-content {
            line-height: 1.75;
            font-size: 1.1rem;
            color: #333;
        }
        .card-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>

<?php include('../includes/Header.php'); ?>

<main class="main-content">
    <div class="container-lg py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="ArticlePage.php">Articles</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($article['title']) ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12">
                <article class="card shadow border-0 p-4">
                    <h1 class="card-title text-center"><?= htmlspecialchars($article['title']) ?></h1>
                    <div class="row mt-4">
                        <?php if (!empty($article['image_url'])): ?>
                            <div class="col-md-6 mb-3 mb-md-0">
                                <img src="../uploads/<?= htmlspecialchars($article['image_url']) ?>" alt="Article image" class="article-image" loading="lazy" decoding="async" />
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="article-content" id="article-content">
                                <?= nl2br(htmlspecialchars($article['content'])) ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end bg-white border-0 mt-4">
                        <a href="ArticlePage.php" class="btn btn-outline-primary">← Back to list</a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</main>

<?php include('../includes/Footer.php'); ?>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
