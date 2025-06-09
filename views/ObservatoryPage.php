<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/ObservatoryController.php';

$controller = new ObservatoryController();
$response = $controller->index();

// Initialize observatories as empty array
$observatories = [];

// Safely check response structure
if (is_array($response) && isset($response['status']) && $response['status'] === 'success') {
    if (isset($response['data']['observatories'])) {
        $observatories = $response['data']['observatories'];
    }
}

$error = $_GET['error'] ?? null;
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Space Dot Com | Observatories</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding-top: 76px;
        }

        .bg-observatory {
            position: relative;
            background-image: url('../assets/images/pexels-photo-447329.webp');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            min-height: 600px;
            width: 100%;
            display: flex;
            align-items: center;
            color: white;
            overflow: hidden;
            z-index: 0;
        }

        .obser-group {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px 0;
            width: 100%;
        }

        .obser-card {
            width: 100%;
            height: 350px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            transition: 0.5s;
            cursor: pointer;
        }

        .obser-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
            transition: 0.5s;
        }

        .obser-card .layer {
            background: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0));
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 75%;
            opacity: 0;
            transition: 0.3s;
        }

        .obser-card .info {
            position: absolute;
            bottom: -50%;
            padding: 15px;
            opacity: 0;
            transition: 0.5s bottom, 1.75s opacity;
        }

        .info p {
            font-size: 14px;
            margin-top: 3px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .info a {
            text-decoration: none;
            background: #490CCC;
            border: none;
            padding: 8px 12px;
            font-weight: bold;
            border-radius: 8px;
            margin-top: 8px;
        }

        .obser-card:hover,
        .obser-card:hover img,
        .obser-card:hover .layer {
            transform: scale(1.1);
        }

        .obser-card:hover>.layer {
            opacity: 1;
        }

        .obser-card:hover .info {
            bottom: 0;
            opacity: 1;
        }

        .obser-group:hover>.obser-card:not(:hover) {
            filter: blur(5px);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include(__DIR__ . '/../includes/Header.php'); ?>
    </header>

    <!-- Section: Observatory Header -->
    <section class="bg-observatory" data-aos="fade-down">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Observatories</h1>
                    <p class="lead">Discover the world's most advanced astronomical observatories and their contributions to space exploration.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Main Content -->
    <main class=" mb-3">
        <!-- Section: Introduction -->
        <section class="section">
            <div class="container">
                <h2 class="display-4 fw-bold mb-4 text-dark mt-4" data-aos="fade-up">Introduction</h2>
                <div class="mb-4 fs-5" data-aos="fade-up" data-aos-delay="100">
                    <p class="mb-3">
                        Astronomical observatories are facilities equipped with powerful telescopes and instruments designed to observe celestial objects and phenomena. These observatories play a crucial role in advancing our understanding of the universe, from studying distant galaxies to monitoring our own solar system.
                    </p>
                    <p>
                        Modern observatories are often located in remote areas with clear skies and minimal light pollution, allowing astronomers to capture the clearest possible views of the cosmos. Some are even placed in space, like the Hubble Space Telescope, to avoid atmospheric interference entirely.
                    </p>
                </div>
            </div>
        </section>
        <div class="border-top my-3 mx-auto" style="width: 80%;"></div>
        <!-- Section: Observatory List -->
        <section class="section">
            <div class="container-fluid px-4">
                <?php if ($message): ?>
                    <div class="alert <?php echo strpos($status, 'failed') === false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($observatories)): ?>
                    <div class="obser-group">
                        <?php foreach ($observatories as $observatory): ?>
                            <div class="obser-card">
                                <img src="../<?= htmlspecialchars($observatory->getImageUrl()) ?>"
                                    alt="<?= htmlspecialchars($observatory->getName()) ?>">
                                <div class="layer"></div>
                                <div class="info">
                                    <h1 style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                                        <?= htmlspecialchars($observatory->getName()) ?>
                                    </h1>
                                    <p>
                                        <?php
                                        $description = htmlspecialchars($observatory->getDescription());
                                        echo strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description;
                                        ?>
                                    </p>
                                    <a href="ObservatoryDetails.php?id=<?= $observatory->getId() ?>"
                                        class="btn btn-primary">
                                        Learn More
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center">
                        <p class="text-muted">No observatories found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <?php include(__DIR__ . '/../includes/Footer.php'); ?>
    </footer>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>