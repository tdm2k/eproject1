<?php
require_once __DIR__ . '/../models/ConstellationModel.php';
$constellationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($constellationId <= 0) die('Invalid constellation ID.');
$model = new ConstellationModel();
$constellation = $model->getConstellationById($constellationId);
if (!$constellation) die('Constellation not found.');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Space Dot Com | <?= htmlspecialchars($constellation['name']) ?></title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .constellation-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }
        .constellation-image:hover {
            transform: scale(1.05);
        }
        .card-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
        }
        .info-label {
            font-weight: 600;
        }
        .card-body p {
            line-height: 1.6;
            font-size: 1.1rem;
            color: #333;
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
                <li class="breadcrumb-item"><a href="ConstellationPage.php">Constellations</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($constellation['name']) ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12">
                <article class="card shadow border-0 p-4">
                    <div class="card-body">
                        <!-- Main Title -->
                        <h1 class="card-title mb-4 text-center"><?= htmlspecialchars($constellation['name']) ?></h1>

                        <!-- Two columns -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <?php if (!empty($constellation['image'])): ?>
                                    <img src="../uploads/<?= htmlspecialchars($constellation['image']) ?>" alt="Constellation image" class="constellation-image" loading="lazy" decoding="async" />
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <?php if (!empty($constellation['notable_stars'])): ?>
                                    <p><span class="info-label">Notable Stars:</span> <?= htmlspecialchars($constellation['notable_stars']) ?></p>
                                <?php endif; ?>

                                <?php if (!empty($constellation['position'])): ?>
                                    <p><span class="info-label">Coordinates:</span> <?= htmlspecialchars($constellation['position']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Description -->
                        <?php if (!empty($constellation['description'])): ?>
                            <p><span class="info-label">Description:</span> <?= nl2br(htmlspecialchars($constellation['description'])) ?></p>
                        <?php endif; ?>

                        <!-- Legend -->
                        <?php if (!empty($constellation['legend'])): ?>
                            <p><span class="info-label">Legend:</span><br><?= nl2br(htmlspecialchars($constellation['legend'])) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-end bg-white border-0">
                        <a href="ConstellationPage.php" class="btn btn-outline-primary">← Back to list</a>
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
