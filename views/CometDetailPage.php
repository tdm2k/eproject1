<?php
require_once '../models/CometModel.php';
require_once '../entities/Comet.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$cometModel = new CometModel();
$comet = $cometModel->getCometById($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($comet->getName()) ?></title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding-top: 76px;
            /* Chiều cao của navbar */
        }

        .bg-comet {
            position: relative;
            background-image: url('../<?php echo $comet->getImage(); ?>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            color: white;
            overflow: hidden;
            z-index: 0;
        }

        .bg-comet::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .bg-comet>* {
            position: relative;
            z-index: 2;
        }

        .detail-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section {
            padding: 60px 0;
        }

        .detail-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
</head>

<body>
    <?php include '../includes/Header.php'; ?>

    <!-- Section: Comet Header -->
    <section class="bg-comet" data-aos="zoom-in" data-aos-delay="100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up" data-aos-delay="200"><?php echo htmlspecialchars($comet ? $comet->getName() : 'Comet Details'); ?></h1>
                    <p class="fs-5" data-aos="fade-up" data-aos-delay="300"> <?php echo htmlspecialchars($comet->getFeatures()); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Comet Details -->
    <section class="section">
        <div class="container">
            <?php if ($comet): ?>
                <div class="container">
                    <!-- Thông tin chính -->
                    <div class="row mb-5">
                        <div class="col-lg-6 ms-auto text-end">
                            <ul class="list-unstyled fs-5">
                                <li class="detail-item" data-aos="fade-left" data-aos-delay="100">
                                    <strong>Last Observed:</strong>
                                    <?= htmlspecialchars($comet->getLastObserved() ?? 'Unknown') ?>
                                </li>
                                <li class="detail-item" data-aos="fade-left" data-aos-delay="200">
                                    <strong>Orbital Period:</strong>
                                    <?= htmlspecialchars($comet->getOrbitalPeriodYears() !== null ? $comet->getOrbitalPeriodYears() . ' years' : 'Unknown') ?>
                                </li>
                                <li class="detail-item" data-aos="fade-left" data-aos-delay="300">
                                    <strong>Key Features:</strong>
                                    <?= htmlspecialchars($comet->getFeatures() ?? 'Not available') ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Mô tả chi tiết -->
                    <div class="row" data-aos="fade-up" data-aos-delay="400">
                        <div class="col-12">
                            <h2 class="display-6 fw-semibold mb-3">Overview</h2>
                            <p class="fs-5"><?= html_entity_decode(htmlspecialchars($comet->getDescription() ?? 'No description available.')) ?></p>
                        </div>
                    </div>

                    <!-- Hình ảnh -->
                    <div class="row mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="500">
                        <div class="col-lg-6 text-center">
                            <?php if ($comet->getImage()): ?>
                                <img src="../<?= htmlspecialchars($comet->getImage()) ?>"
                                    alt="<?= htmlspecialchars($comet->getName()) ?>"
                                    class="img-fluid rounded shadow-sm comet-image mb-4">
                            <?php else: ?>
                                <img src="../assets/images/no-image.png"
                                    alt="No image"
                                    class="img-fluid rounded shadow-sm comet-image mb-4">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <p class="text-muted">Comet not found.</p>
                    <a href="CometPage.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Back to Comets
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include '../includes/Footer.php'; ?>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>