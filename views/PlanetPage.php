<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gọi PlanetController để lấy dữ liệu
require_once '../controllers/PlanetController.php';
$controller = new PlanetController();
$response = $controller->index();
$planets = $response['status'] === 'success' ? $response['data']['planets'] : [];
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
    <title>Space Dot Com | Planets</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            padding-top: 76px;
            /* Chiều cao của navbar */
        }

        .bg-planet {
            position: relative;
            background-image: url('../assets/images/background-planet.jpg');
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

        .text-truncate-multiline {
            width: 500px;
        }

        .text-size {
            font-size: 80px;
            color: #288bff;
        }

        .planet-card {
            overflow: hidden;
            border: none !important;
        }

        .planet-card img {
            transition: transform 0.5s ease;
        }

        .planet-card:hover img {
            transform: scale(1.1);
        }

        .section {
            padding: 60px 0;
        }

        .section-title {
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <?php include '../includes/Header.php'; ?>

    <!-- Section: About the Planets -->
    <section class="bg-planet">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up" data-aos-delay="100">About the Planets</h1>
                    <p class="fs-5 mb-5" data-aos="fade-up" data-aos-delay="200">
                        Our solar system has eight planets: Mercury, Venus, Earth, Mars, Jupiter, Saturn, Uranus, and Neptune.
                        There are five officially recognized dwarf planets in our solar system: Ceres, Pluto, Haumea, Makemake, and Eris.
                    </p>
                    <div class="d-flex">
                        <div class="d-flex gap-4 align-items-center" style="height: 200px; margin-right: 100px;">
                            <div class="text-size" data-aos="zoom-in" data-aos-delay="400">8</div>
                            <div class="fs-5 fw-semibold" data-aos="fade-up" data-aos-delay="500">Planets</div>
                        </div>
                        <div class="d-flex gap-4 align-items-center" style="height: 200px;">
                            <div class="text-size" data-aos="zoom-in" data-aos-delay="600">5</div>
                            <div class="fs-5 fw-semibold" data-aos="fade-up" data-aos-delay="700">Dwarf Planets</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Introduction -->
    <section class="section">
        <div class="container">
            <h2 class="display-4 fw-bold mb-4" data-aos="fade-up" data-aos-delay="100">Introduction</h2>
            <div class="mb-4 fs-5" data-aos="fade-up" data-aos-delay="200">
                <p class="mb-3">
                    What is a planet? The word goes back to the ancient Greek word <i>planēt</i>, and it means "wanderer."
                    A more modern definition can be found in the Merriam-Webster dictionary, which defines a planet as
                    "any of the large bodies that revolve around the Sun in the solar system."
                </p>
                <p>
                    In 2006, the International Astronomical Union (IAU) - a group of astronomers that names objects
                    in our solar system - agreed on their own definition of the word "planet." This new definition
                    caused Pluto's famous "demotion" to a dwarf planet.
                </p>
            </div>
            <a href="PlanetReadMore.php" class="text-decoration-none fw-bold text-primary fs-5" data-aos="fade-up" data-aos-delay="300">Read more
                <i class="bi bi-arrow-right-square-fill"></i>
            </a>
        </div>
    </section>
    <div class="border-top my-3 mx-auto" style="width: 85%;"></div>

    <!-- Section: Planets List -->
    <section class="section">
        <div class="container mb-5">
            <h2 class="display-5 fw-bold">Planets</h2>
        </div>
        <div class="container">
            <?php if (!empty($planets)): ?>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <?php 
                    $delay = 0;
                    foreach ($planets as $planet): 
                        $delay += 100; // Tăng delay 100ms cho mỗi hành tinh
                    ?>
                        <div class="col" data-aos="flip-left" data-aos-delay="<?php echo $delay; ?>">
                            <div class="card planet-card h-100" style="width: 100%;">
                                <div class="overflow-hidden">
                                    <?php if ($planet->getImage()): ?>
                                        <img src="../<?php echo htmlspecialchars($planet->getImage()); ?>"
                                            alt="<?php echo htmlspecialchars($planet->getName()); ?>"
                                            class="card-img-top">
                                    <?php else: ?>
                                        <img src="../assets/images/no-image.png"
                                            alt="No image"
                                            class="card-img-top">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fs-4"><?php
                                                                $title = html_entity_decode(htmlspecialchars($planet->getName() ?? 'N/A'));
                                                                echo strlen($title) > 50 ? substr($title, 0, 50) . '...' : $title;
                                                                ?></h5>
                                    <p class="card-text">
                                        <?php
                                        $desc = html_entity_decode(htmlspecialchars($planet->getDescription() ?? 'N/A'));
                                        echo strlen($desc) > 90 ? substr($desc, 0, 90) . '...' : $desc;
                                        ?>
                                    </p>
                                    <a href="PlanetDetailPage.php?id=<?php echo $planet->getId(); ?>" class="text-decoration-none fw-bold text-primary fs-5">
                                        Explore <?php echo html_entity_decode(htmlspecialchars($planet->getName() ?? 'N/A')); ?>
                                        <i class="bi bi-arrow-right-square-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">No planets found.</p>
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