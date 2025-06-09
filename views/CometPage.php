<?php
require_once '../models/CometModel.php';
require_once '../entities/Comet.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cometModel = new CometModel();
$comets = $cometModel->getAllComets();
sort($comets);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Comets</title>
    <!-- Bootstrap -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            padding-top: 76px;
        }

        .bg-comet {
            position: relative;
            background-image: url('../assets/images/comet-page.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            min-height: 800px;
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

        .section {
            padding: 60px 0;
        }

        .section-title {
            margin-bottom: 40px;
        }

        .text-truncate-multiline {
            width: 500px;
        }

        .text-size {
            font-size: 80px;
            color: #288bff;
        }

        .comet-card {
            overflow: hidden;
            border: none !important;
        }

        .comet-card img {
            transition: transform 0.5s ease;
        }

        .comet-card:hover img {
            transform: scale(1.1);
        }

        .comet-card .card-img-top {
            height: 300px;
            object-fit: cover;
            object-position: center center;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div>
        <?php include('../includes/Header.php'); ?>
    </div>

    <section class="bg-comet">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up" data-aos-delay="100">Admire the Comets</h1>
                    <p class="fs-5 mb-5" data-aos="fade-up" data-aos-delay="200">
                        Once seen as omens from the gods, comets are dazzling celestial visitors that streak across the night sky before vanishing into the depths of space. They carry ancient materials from the early days of the solar system, offering clues to the origins and evolution of our cosmic neighborhood.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="display-4 fw-bold mb-4" data-aos="fade-up" data-aos-delay="100">Introduction</h2>
            <div class="mb-4 fs-5" data-aos="fade-up" data-aos-delay="200">
                <p class="mb-3">
                    What is a comet? The word comes from the Greek word <i>komētēs</i>, meaning "long-haired," a reference to the glowing tails that trail behind these icy celestial bodies as they approach the Sun.
                    Comets are made of dust, rock, and frozen gases, and they orbit the Sun in long, elliptical paths, often taking hundreds or even thousands of years to complete a single journey.
                </p>
                <p>
                    Throughout history, comets have fascinated and frightened observers, sometimes interpreted as omens. Today, scientists study comets to uncover clues about the early solar system, as these ancient travelers preserve pristine materials from its formation over 4.6 billion years ago.
                </p>
            </div>
        </div>
    </section>
    <div class="border-top my-3 mx-auto" style="width: 85%;"></div>

    <section class="section">
        <div class="container mb-5">
            <h2 class="display-5 fw-bold">Comets</h2>
        </div>
        <div class="container">
            <?php if (!empty($comets)): ?>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <?php
                    $delay = 0;
                    foreach ($comets as $comet):
                        $delay += 100;
                    ?>
                        <div class="col" data-aos="flip-left" data-aos-delay="<?php echo $delay; ?>">
                            <div class="card comet-card h-100" style="width: 100%;">
                                <div class="overflow-hidden">
                                    <?php if ($comet->getImage()): ?>
                                        <img src="../<?php echo htmlspecialchars($comet->getImage()); ?>"
                                            alt="<?php echo htmlspecialchars($comet->getName()); ?>"
                                            class="card-img-top">
                                    <?php else: ?>
                                        <img src="../assets/images/no-image.png"
                                            alt="No image"
                                            class="card-img-top">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fs-4"><?php
                                                                $title = html_entity_decode(htmlspecialchars($comet->getName() ?? 'N/A'));
                                                                echo strlen($title) > 50 ? substr($title, 0, 50) . '...' : $title;
                                                                ?></h5>
                                    <p class="card-text">
                                        <?php
                                        $desc = html_entity_decode(htmlspecialchars($comet->getDescription() ?? 'N/A'));
                                        echo strlen($desc) > 90 ? substr($desc, 0, 90) . '...' : $desc;
                                        ?>
                                    </p>
                                    <a href="CometDetailPage.php?id=<?php echo $comet->getId(); ?>" class="text-decoration-none fw-bold text-primary fs-5"> Explore <?php echo html_entity_decode(htmlspecialchars($comet->getName() ?? 'N/A')); ?> <i class="bi bi-arrow-right-square-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">No comets found.</p> <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <div>
        <?php include('../includes/Footer.php'); ?>
    </div>

    <!-- Bootstrap -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>