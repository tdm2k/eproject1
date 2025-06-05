<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/ObservatoryController.php';

// Get ID from URL and call controller
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$controller = new ObservatoryController();

// Get observatory details
function getObservatoryDetails(ObservatoryController $controller, ?int $id): array
{
    if (!$id) {
        return ['status' => 'error', 'message' => 'Invalid observatory ID'];
    }
    try {
        $response = $controller->show($id);
        if ($response['status'] === 'success' && $response['data']) {
            return ['status' => 'success', 'data' => $response['data']];
        } else {
            return ['status' => 'error', 'message' => 'Observatory not found'];
        }
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => 'Failed to fetch observatory: ' . $e->getMessage()];
    }
}

$response = getObservatoryDetails($controller, $id);
$observatory = $response['status'] === 'success' && $response['data'] ? $response['data'] : null;
$error_message = $response['status'] === 'error' ? $response['message'] : null;

// Get messages from query string (if any)
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($observatory ? $observatory->getName() : 'Observatory Details') ?></title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --transition: all 0.3s ease;
        }

        body {
            padding-top: 76px;
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('../<?= $observatory && $observatory->getImageUrl() ? $observatory->getImageUrl() : 'assets/images/no-image.png' ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 70vh;
            display: flex;
            align-items: center;
            color: white;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 4rem 0;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        /* Content Sections */
        .content-section {
            padding: 5rem 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--dark-color);
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 4px;
            background-color: var(--primary-color);
        }

        .detail-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: var(--transition);
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .detail-card h3 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .detail-card p {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        /* Image Display */
        .main-image-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
            cursor: pointer;
            transition: var(--transition);
        }

        .main-image-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .main-image-container img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: var(--transition);
        }

        .main-image-container:hover img {
            transform: scale(1.05);
        }

        .image-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 1.5rem;
            font-size: 1.1rem;
        }

        /* Quick Facts */
        .quick-facts {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .fact-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .fact-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .fact-label {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .fact-value {
            color: var(--secondary-color);
        }

        /* Buttons */
        .btn-custom {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <?php include '../includes/Header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section" data-aos="fade">
        <div class="container">
            <div class="hero-content">
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Explore the universe from
                    <i class="hero-title" data-aos="fade-up">
                        <?= htmlspecialchars($observatory ? $observatory->getName() : 'Observatory Details') ?>
                    </i>
                </p>
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">Where science meets wonder.</p>

            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content-section">
        <div class="container">
            <?php if ($message): ?>
                <div class="alert <?= strpos($status, 'failed') === false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error_message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($observatory): ?>
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-7">
                        <?php if ($observatory->getImageUrl()): ?>
                            <div class="main-image-container" data-aos="fade-up">
                                <img src="../<?= htmlspecialchars($observatory->getImageUrl()) ?>"
                                    alt="<?= htmlspecialchars($observatory->getName()) ?>"
                                    loading="lazy">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5">
                        <div class="quick-facts" data-aos="fade-left">
                            <div class="fact-item" data-aos="fade-left" data-aos-delay="200">
                                <div class="fact-label fs-4">Location:</div>
                                <div class="fact-value"><?= nl2br(html_entity_decode($observatory->getLocation())) ?></div>
                            </div>
                            <div class="fact-item" data-aos="fade-left" data-aos-delay="300">
                                <div class="fact-label fs-4">Did You Know?</div>
                                <div class="fact-value">
                                    Observatories play a crucial role in advancing our understanding of the universe, studying everything from stars and planets to cosmic phenomena.
                                </div>
                            </div>
                            <div class="fact-item mt-3" data-aos="fade-left" data-aos-delay="400">
                                <div class="fact-label fs-4">Fun Fact <i class="bi bi-emoji-smile"></i></div>
                                <div class="fact-value">
                                    Many observatories are located at high altitudes to minimize atmospheric interference, ensuring clearer views of space.
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="ObservatoryPage.php" class="btn btn-primary btn-custom w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Observatories
                                </a>
                            </div>
                        </div>
                    </div>

                    <h2 class="section-title" data-aos="fade-right">About This Observatory</h2>
                    <div class="detail-card" data-aos="fade-up">
                        <div class="description">
                            <?= nl2br(html_entity_decode($observatory->getDescription())) ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-exclamation-circle text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="mb-4">Observatory Not Found</h2>
                    <p class="text-muted mb-4">The observatory you're looking for doesn't exist or has been removed.</p>
                    <a href="ObservatoryPage.php" class="btn btn-primary btn-custom">
                        <i class="bi bi-arrow-left me-2"></i>Back to Observatories
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
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>

</html>