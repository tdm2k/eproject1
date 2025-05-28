<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đường dẫn chính xác đến các file
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../controllers/ConstellationController.php';
require_once __DIR__ . '/../entities/Constellation.php'; // nếu cần

// Khởi tạo connection
$connInstance = new Connection();
$conn = $connInstance->getConnection();

// Tạo controller với connection
$controller = new ConstellationController($conn);
$constellations = $controller->getAllConstellations();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Space Dot Com | Constellations</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<body>
    <!-- Header -->
    <div>
        <?php include('../includes/Header.php'); ?>
    </div>

    <!-- Page Content -->
    <div class="container" style="margin-top: 6%">
        <h2 class="mb-4">Danh sách chòm sao</h2>
        <div class="row">
            <?php foreach ($constellations as $c): ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($c->getName()) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($c->getDescription())) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <div>
        <?php include('../includes/Footer.php'); ?>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
