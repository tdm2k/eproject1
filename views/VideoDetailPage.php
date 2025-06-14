<?php
require_once __DIR__ . '/../models/VideoModel.php';
$model = new VideoModel();

// Lấy ID từ URL
$videoId = $_GET['id'] ?? null;
$video = null;

if ($videoId !== null) {
    $video = $model->getById((int)$videoId);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Video Detail | Space Dot Com</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 76px;
        }

        .video-content {
            padding: 60px 0;
        }

        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 12px;
        }

        .video-embed iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .back-link {
            margin-bottom: 20px;
            display: inline-block;
            color: #0d6efd;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .description {
            white-space: pre-line;
        }
    </style>
</head>

<body>
    <?php include('../includes/Header.php'); ?>

    <main class="video-content">
        <div class="container">
            <a href="VideoPage.php" class="back-link">&larr; Back to Videos</a>
            <?php if ($video): ?>
                <div data-aos="fade-up">
                    <h2 class="fw-bold"><?= htmlspecialchars($video->getTitle()) ?></h2>
                    <p class="text-muted mb-4">Uncategorized</p>

                    <div class="video-embed mb-4">
                        <?php
                        $url = trim($video->getUrl());
                        $embedUrl = '';

                        if (!empty($url)) {
                            if (strpos($url, 'watch?v=') !== false) {
                                parse_str(parse_url($url, PHP_URL_QUERY), $query);
                                $videoId = $query['v'] ?? '';
                                $embedUrl = "https://www.youtube.com/embed/" . htmlspecialchars($videoId);
                            } elseif (strpos($url, 'youtu.be/') !== false) {
                                $videoId = substr($url, strrpos($url, '/') + 1);
                                $embedUrl = "https://www.youtube.com/embed/" . htmlspecialchars($videoId);
                            }

                            if ($embedUrl) {
                                echo "<iframe src=\"$embedUrl\" frameborder=\"0\" allowfullscreen></iframe>";
                            } else {
                                echo "<p class='text-danger'>Invalid or unsupported video URL.</p>";
                            }
                        } else {
                            echo "<p class='text-danger'>No video URL provided.</p>";
                        }
                        ?>
                    </div>

                    <div class="description">
                        <?= nl2br(htmlspecialchars($video->getDescription())) ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <strong>Video not found.</strong>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include('../includes/Footer.php'); ?>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>