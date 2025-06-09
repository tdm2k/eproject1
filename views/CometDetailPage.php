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

    <?php include '../includes/Footer.php'; ?>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>