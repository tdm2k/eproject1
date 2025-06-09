<?php
require_once __DIR__ . '/../models/ArticleModel.php';
$model = new ArticleModel();
$articles = $model->getAllArticles();
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
        .bg-article {
            background-image: url('https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?auto=format&fit=crop&w=1470&q=80');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 500px;
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
            padding: 60px 0;
        }
        .article-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .article-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            height: 350px;
            cursor: pointer;
            transition: 0.5s;
        }
        .article-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }
        .article-card .layer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 75%;
            background: linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0));
            opacity: 0;
            transition: 0.3s;
        }
        .article-card .info {
            position: absolute;
            bottom: -50%;
            left: 0;
            right: 0;
            padding: 15px;
            color: white;
            opacity: 0;
            transition: 0.5s bottom, 1.5s opacity;
        }
        .article-card:hover img,
        .article-card:hover .layer {
            transform: scale(1.05);
        }
        .article-card:hover .layer {
            opacity: 1;
        }
        .article-card:hover .info {
            bottom: 0;
            opacity: 1;
        }
        .article-group:hover .article-card:not(:hover) {
            filter: blur(3px);
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
            <?php if (!empty($articles)): ?>
                <div class="article-group">
                    <?php foreach ($articles as $article): ?>
                        <div class="article-card">
                            <a href="ArticleDetail.php?id=<?= $article['id'] ?>">
                                <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                                <div class="layer"></div>
                                <div class="info">
                                    <h5><?= htmlspecialchars($article['title']) ?></h5>
                                    <p>
                                        <?php
                                            $desc = strip_tags($article['content']);
                                            echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                                        ?>
                                    </p>
                                    <a href="ArticleDetail.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-light mt-2">Read more</a>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted text-center">No articles available.</p>
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
