<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../controllers/PlanetController.php';

// Lấy ID từ URL và gọi controller
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$controller = new PlanetController();

// Giả lập phương thức show() nếu chưa có trong PlanetController
function getPlanetDetails(PlanetController $controller, ?int $id): array
{
    if (!$id) {
        return ['status' => 'error', 'message' => 'Invalid planet ID'];
    }
    $model = new PlanetModel();
    try {
        $planet = $model->getPlanetById($id);
        if ($planet) {
            return ['status' => 'success', 'data' => $planet];
        } else {
            return ['status' => 'error', 'message' => 'Planet not found'];
        }
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => 'Failed to fetch planet: ' . $e->getMessage()];
    }
}

$response = getPlanetDetails($controller, $id);
$planet = $response['status'] === 'success' && $response['data'] ? $response['data'] : null;
$error_message = $response['status'] === 'error' ? $response['message'] : null;

// Lấy thông báo từ query string (nếu có)
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Planet Details</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            padding-top: 76px;
            /* Chiều cao của navbar */
        }

        .bg-planet {
            position: relative;
            background-image: url('../<?php echo $planet->getImage(); ?>');
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

        .bg-planet::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .bg-planet>* {
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

    <!-- Section: Planet Header -->
    <section class="bg-planet">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4"><?php echo htmlspecialchars($planet ? $planet->getName() : 'Planet Details'); ?></h1>
                    <p class="fs-5">Discover more about this fascinating celestial body</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Planet Details -->
    <section class="section">
        <div class="container">
            <?php if ($message): ?>
                <div class="alert <?php echo strpos($status, 'failed') === false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                    <?php echo html_entity_decode(htmlspecialchars($message)); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo html_entity_decode(htmlspecialchars($error_message)); ?>
                </div>
            <?php elseif ($planet): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <h2 class="display-5 fw-bold"><?php echo nl2br(html_entity_decode($planet->getName())); ?> Facts</h2>
                            <p><?= nl2br(html_entity_decode($planet->getDescription())) ?></p>
                        </div>
                        <div class="col-lg-5">
                            <div class="row" style="font-size: 16px;">
                                <div class="col-6">
                                    <ul class="list-unstyled">
                                        <li class="border-bottom py-2">
                                            <a href="#introducation" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Introduction <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#potential-life" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Potential for Life <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#orbit-rotation" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Orbit and Rotation <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#rings" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Rings <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#structure" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Structure <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#atmosphere" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Atmosphere <span>&#x2193;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled">
                                        <li class="border-bottom py-2">
                                            <a href="#name-sake" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Namesake <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#size-distance" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Size and Distance <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#moons" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Moons <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#formation" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Formation <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#surface" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Surface <span>&#x2193;</span>
                                            </a>
                                        </li>
                                        <li class="border-bottom py-2">
                                            <a href="#magnetosphere" class="d-flex justify-content-between text-decoration-none text-dark">
                                                Magnetosphere <span>&#x2193;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if ($planet->getImage()): ?>
                            <img src="../<?php echo html_entity_decode(htmlspecialchars($planet->getImage())); ?>"
                                alt="<?php echo html_entity_decode(htmlspecialchars($planet->getName())); ?>"
                                class="planet-img img-fluid rounded mb-4">
                        <?php else: ?>
                            <img src="../assets/images/no-image.png" alt="No image" class="img-fluid rounded planet-img mb-4">
                        <?php endif; ?>

                        <div class="container">
                            <div id="introducation" class="mb-5">
                                <h1>Introducation</h1>
                                <p><?= nl2br(html_entity_decode($planet->getDescription())) ?></p>
                            </div>

                            <div id="name-sake" class="mb-5">
                                <h1>Namesake</h1>
                                <p><?= nl2br(html_entity_decode($planet->getNameSake())) ?></p>
                            </div>

                            <div id="size-distance" class="mb-5">
                                <h1>Size & Distance</h1>
                                <p><?= nl2br(html_entity_decode($planet->getSizeAndDistance())) ?></p>
                            </div>

                            <div id="rings" class="mb-5">
                                <h1>Rings</h1>
                                <p>
                                    <?php
                                    $planetName = nl2br(html_entity_decode($planet->getName() ?? 'This planet'));
                                    echo $planet->getRings() ? "$planetName has rings." : "$planetName has no rings.";
                                    ?>
                                </p>
                            </div>

                            <div id="moons" class="mb-5">
                                <h1>Moons</h1>
                                <p><?= nl2br(html_entity_decode($planet->getMoons() ?? 'N/A')) ?></p>
                            </div>

                            <div id="structure" class="mb-5">
                                <h1>Structure</h1>
                                <p><?= nl2br(html_entity_decode($planet->getStructure() ?? 'N/A')) ?></p>
                            </div>

                            <div id="surface" class="mb-5">
                                <h1>Surface</h1>
                                <p><?= nl2br(html_entity_decode($planet->getSurface() ?? 'N/A')) ?></p>
                            </div>

                            <div id="atmosphere" class="mb-5">
                                <h1>Atmosphere</h1>
                                <p><?= nl2br(html_entity_decode($planet->getAtmosphere() ?? 'N/A')) ?></p>
                            </div>

                            <div id="magnetosphere" class="mb-5">
                                <h1>Magnetosphere</h1>
                                <p><?= nl2br(html_entity_decode($planet->getMagnetosphere() ?? 'N/A')) ?></p>
                            </div>

                            <div id="orbit-rotation" class="mb-5">
                                <h1>Orbit & Rotation</h1>
                                <p><?= nl2br(html_entity_decode($planet->getOrbitAndRotation() ?? 'N/A')) ?></p>
                            </div>

                            <div id="formation" class="mb-5">
                                <h1>Formation</h1>
                                <p><?= nl2br(html_entity_decode($planet->getFormation() ?? 'N/A')) ?></p>
                            </div>

                            <div id="potential-life" class="mb-5">
                                <h1>Potential for Life</h1>
                                <p><?= nl2br(html_entity_decode($planet->getPotentialForLife() ?? 'N/A')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <p class="text-muted">Planet not found.</p>
                    <a href="PlanetPage.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Back to Planets
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include '../includes/Footer.php'; ?>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>