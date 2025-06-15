<?php
require_once __DIR__ . '/../models/ArticleModel.php';
$model = new ArticleModel();

// Cấu hình phân trang
$limit = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$articles = $model->getAllArticlesPaginated($limit, $offset);
$totalArticles = $model->getTotalArticles();
$totalPages = ceil($totalArticles / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Space Dot Com | Articles</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding-top: 76px;
        }
        .bg-article {
            background-image: url('../assets/images/bg_article.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 820px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: white;
            text-shadow: 2px 2px 4px #000;
        }
        .bg-article .overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .bg-article .container {
            position: relative;
            z-index: 1;
        }
        .article-intro {
            padding: 60px 0 30px;
        }
        .article-item {
            margin-bottom: 40px;
        }
        .article-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }
        .article-item .content h4 {
            font-weight: bold;
        }
        .article-item .content p {
            color: #555;
        }
    </style>
</head>
<body>
<?php include('../includes/Header.php'); ?>

<!-- Header section -->
<section class="bg-article" data-aos="fade-down">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Articles & News</h1>
        <p class="lead">Discover fascinating stories about space, science, and many more exciting topics!</p>
    </div>
</section>

<main class="mb-5">
    <!-- Introduction -->
    <section class="article-intro">
        <div class="container">
            <h2 class="display-5 fw-bold mb-3 text-primary" data-aos="fade-up">Introduction</h2>
            <p class="fs-5" data-aos="fade-up" data-aos-delay="100">
                We bring you the most interesting articles about the universe, from astronomical discoveries to major space events. Whether you're a beginner or a space enthusiast, you'll find something valuable here.
            </p>
        </div>
    </section>

    <!-- Article list -->
    <section>
        <div class="container">
            <h3 class="mb-4 text-dark" data-aos="fade-right">Below are the latest articles:</h3>

            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="row article-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="col-md-4">
                            <img src="../uploads/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                        </div>
                        <div class="col-md-8 content">
                            <h4><?= htmlspecialchars($article['title']) ?></h4>
                            <p>
                                <?php
                                    $desc = strip_tags($article['content']);
                                    echo strlen($desc) > 200 ? substr($desc, 0, 200) . '...' : $desc;
                                ?>
                            </p>
                            <a href="ArticleDetail.php?id=<?= $article['id'] ?>" class="btn btn-outline-primary btn-sm">
                                Read more <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted text-center">No articles available.</p>
            <?php endif; ?>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="bi bi-chevron-left"></i></a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
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
            <?php endif; ?>

        </div>
    </section>
</main>

<?php include('../includes/Footer.php'); ?>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
