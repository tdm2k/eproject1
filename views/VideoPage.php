<?php
require_once __DIR__ . '/../models/VideoModel.php';
$model = new VideoModel();
$videos = $model->getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Space Dot Com | Videos</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 76px;
        }

        .bg-video-header {
            position: relative;
            background-image: url('https://th.bing.com/th/id/OIP.aWyJNaX6_LSprOxJBqI6LAHaEE?w=337&h=185&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
        }

        .bg-video-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .bg-video-header .container {
            position: relative;
            z-index: 1;
        }

        .video-intro {
            padding: 60px 0;
        }

        .video-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .video-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            height: 350px;
            background: #fff;
            box-shadow: 0 6px 15px rgb(0 0 0 / 0.1);
            transition: 0.5s;
            display: flex;
            flex-direction: column;
            cursor: pointer;
        }

        .video-card:hover {
            box-shadow: 0 10px 25px rgb(0 0 0 / 0.25);
        }

        .video-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-radius: 16px 16px 0 0;
            transition: 0.5s transform;
        }

        .video-card:hover img {
            transform: scale(1.05);
        }

        .video-card .layer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 75%;
            background: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0));
            opacity: 0;
            transition: 0.3s;
        }

        .video-card .info {
            position: absolute;
            bottom: -50%;
            left: 0;
            right: 0;
            padding: 15px;
            color: white;
            opacity: 0;
            transition: 0.5s bottom, 1.5s opacity;
        }

        .video-card:hover .layer {
            opacity: 1;
        }

        .video-card:hover .info {
            bottom: 0;
            opacity: 1;
        }

        .video-group:hover .video-card:not(:hover) {
            filter: blur(3px);
        }

        .info h5 {
            margin-bottom: 0.75rem;
        }

        .info p {
            font-size: 0.9rem;
            line-height: 1.3;
        }

        .info .btn {
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <?php include('../includes/Header.php'); ?>

    <section class="bg-video-header" data-aos="fade-down">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Videos</h1>
            <p class="lead">Explore the universe through stunning videos and scientific visuals.</p>
        </div>
    </section>

    <main class="mb-5">
        <section class="video-intro">
            <div class="container">
                <h2 class="display-5 fw-bold mb-3 text-primary" data-aos="fade-up">Why Watch Space Videos?</h2>
                <p class="fs-5" data-aos="fade-up" data-aos-delay="100">
                    Videos help us visualize the wonders of space, from planetary movements to celestial phenomena. These visualizations can enhance our understanding and spark curiosity in astronomy.
                </p>
                <p class="fs-6 text-muted mt-3" data-aos="fade-up" data-aos-delay="200">
                    Enjoy a curated list of videos that illustrate the dynamics of the cosmos in captivating ways.
                </p>
            </div>
        </section>

        <section>
            <div class="container">
                <?php if (!empty($videos)): ?>
                    <div class="video-group" data-aos="fade-up" data-aos-delay="200">
                        <?php foreach ($videos as $v): ?>
                            <div class="video-card">
                                <a href="VideoDetailPage.php?id=<?= $v->getId() ?>" style="color: inherit; text-decoration: none; display: block; height: 100%;">
                                    <?php
                                    $thumb = $v->getThumbnailUrl();
                                    $autoThumb = $v->getAutoThumbnail();

                                    if (!empty($thumb) && file_exists(__DIR__ . '/../uploads/thumbnails/' . $thumb)) {
                                        $imgSrc = '../uploads/thumbnails/' . htmlspecialchars($thumb);
                                    } elseif (!empty($autoThumb)) {
                                        $imgSrc = $autoThumb;
                                    } else {
                                        $imgSrc = 'https://via.placeholder.com/400x190?text=No+Thumbnail';
                                    }
                                    ?>

                                    <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($v->getTitle()) ?>" loading="lazy" />
                                    <div class="layer"></div>
                                    <div class="info">
                                        <h5><?= htmlspecialchars($v->getTitle()) ?></h5>
                                        <p>
                                            <?php
                                            $desc = strip_tags($v->getDescription());
                                            echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                                            ?>
                                        </p>
                                        <span class="btn btn-sm btn-light">Watch Video</span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No videos available.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include('../includes/Footer.php'); ?>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>