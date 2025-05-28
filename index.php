<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Home Page</title>

    <!-- Bootstrap -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/simple-notification.css">

    <style>
        body {
            padding-top: 76px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div>
        <?php include('includes/Header.php'); ?>
    </div>

    <div class="position-relative" style="height: 100vh;" data-aos="zoom-in" data-aos-delay="100">
        <img src="../assets/images/background-home.jpg" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; z-index: 1;" alt="Background">

        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="z-index: 2;"></div>

        <div class="position-absolute start-0 w-100 text-white px-5" style="top: 30%; z-index: 3;">
            <h1 class="display-4 fw-bold">Welcome to the Universe!</h1>
            <p class="lead" style="margin-bottom: 200px;">Embark on a journey through the mysteries and wonders of space.</p>
            <p>From the birth of stars to the deepest black holes, our universe is a canvas of breathtaking phenomena
                <br>waiting to be explored. Discover the latest cosmic events, delve into groundbreaking scientific theorie and
                <br> marvel at stunning celestial photography. Join us as we unravel the secrets of the unknown cosmos.
            </p>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <!-- Success Notification -->
        <?php
        $messages = [
            'logged_out' => 'Logged out successfully!',
            'password_reset_link_sent' => 'Password reset request sent successfully! Please check your email.',
            'password_updated' => 'Password changed successfully!',
            'user_updated' => 'User profile updated successfully!'
        ];

        $msgKey = $_GET['status'] ?? ($_GET['success'] ?? null);

        if ($msgKey && isset($messages[$msgKey])) {
            echo '<div class="alert alert-success success-notification show" role="alert"><i class="bi bi-check-circle-fill me-2"></i> ' . htmlspecialchars($messages[$msgKey]) . '</div>';
        }
        ?>

        <!-- Error Notification -->
        <?php if (isset($_GET['error'])):
            $error = $_GET['error']; ?>
            <div class="alert alert-danger error-notification show" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="row align-items-center my-5">
            <!-- Planet image -->
            <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-delay="200">
                <img src="../assets/images/planets-home.jpg" class="img-fluid rounded shadow" alt="Planet">
            </div>

            <!-- Planet info -->
            <div class="col-md-6 text-center text-md-start" data-aos="fade-left" data-aos-delay="200">
                <h2 class="fw-bold">Planets</h2>
                <p class="lead">
                    Planets are celestial bodies that orbit a star, have enough mass to assume a spherical shape,
                    and follow a clear orbital path. In our Solar System, we have 8 planets including Earth, Mars, Jupiter, and more.
                </p>
                <a href="../views/PlanetPage.php" class="btn btn-outline-primary mt-3">
                    Explore Planets →
                </a>
            </div>
        </div>

        <div class="row align-items-center my-5">
            <!-- Constellation info -->
            <div class="col-md-6 text-center text-md-start" data-aos="fade-right" data-aos-delay="200">
                <h2 class="fw-bold">Constellations</h2>
                <p class="lead">
                    Constellations are patterns of stars in the night sky, used for navigation, storytelling, and astronomy
                    throughout human history. Discover the myths and science behind Orion, Ursa Major, and many more.
                </p>
                <a href="../views/ConstellationPage.php" class="btn btn-outline-primary mt-3">
                    Study Constellations →
                </a>
            </div>

            <!-- Constellation image -->
            <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-left" data-aos-delay="200">
                <img src="../assets/images/constellations-home.jpg" class="img-fluid rounded shadow" alt="Constellations">
            </div>
        </div>

        <div class="row align-items-center my-5">
            <!-- Comet image -->
            <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-delay="200">
                <img src="../assets/images/comets-home.jpg" class="img-fluid rounded shadow" alt="Comets">
            </div>

            <!-- Comet info -->
            <div class="col-md-6 text-center text-md-start" data-aos="fade-left" data-aos-delay="200">
                <h2 class="fw-bold">Comets</h2>
                <p class="lead">
                    Comets are icy celestial bodies that travel through space in long elliptical orbits. As they approach the Sun,
                    they develop bright comas and glowing tails, creating some of the most spectacular sights in the sky.
                </p>
                <a href="../views/CometPage.php" class="btn btn-outline-primary mt-3">
                    Discover Comets →
                </a>
            </div>
        </div>
    </div>

    <div id="quoteCarousel" class="carousel slide my-5" data-bs-ride="carousel">
        <div class="carousel-inner text-center bg-dark text-white rounded shadow p-4">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="../assets/images/quotes/hawking.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Stephen Hawking">
                <h5>Stephen Hawking</h5>
                <p class="lead fst-italic">“Remember to look up at the stars and not down at your feet.”</p>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/sagan.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Carl Sagan">
                <h5>Carl Sagan</h5>
                <p class="lead fst-italic">“The cosmos is within us. We are made of star-stuff.”</p>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/neil.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Neil deGrasse Tyson">
                <h5>Neil deGrasse Tyson</h5>
                <p class="lead fst-italic">“When I look up at the night sky, and I know that yes, we are part of this universe, we are in this universe, but perhaps more important than both of those facts—is that the universe is in us.”</p>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/einstein.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Albert Einstein">
                <h5>Albert Einstein</h5>
                <p class="lead fst-italic">“Look deep into nature, and then you will understand everything better.”</p>
            </div>

            <!-- Slide 5 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/yuri.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Yuri Gagarin">
                <h5>Yuri Gagarin</h5>
                <p class="lead fst-italic">“I see Earth! It is so beautiful.”</p>
            </div>

            <!-- Slide 6 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/armstrong.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Neil Armstrong">
                <h5>Neil Armstrong</h5>
                <p class="lead fst-italic">“That's one small step for man, one giant leap for mankind.”</p>
            </div>

            <!-- Slide 7 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/buzz.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Buzz Aldrin">
                <h5>Buzz Aldrin</h5>
                <p class="lead fst-italic">“Mars is there, waiting to be reached.”</p>
            </div>

            <!-- Slide 8 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/newton.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Isaac Newton">
                <h5>Isaac Newton</h5>
                <p class="lead fst-italic">“If I have seen further it is by standing on the shoulders of Giants.”</p>
            </div>

            <!-- Slide 9 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/galileo.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Galileo Galilei">
                <h5>Galileo Galilei</h5>
                <p class="lead fst-italic">“All truths are easy to understand once they are discovered; the point is to discover them.”</p>
            </div>

            <!-- Slide 10 -->
            <div class="carousel-item">
                <img src="../assets/images/quotes/edwin.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Edwin Hubble">
                <h5>Edwin Hubble</h5>
                <p class="lead fst-italic">“Equipped with his five senses, man explores the universe around him and calls the adventure Science.”</p>
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#quoteCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#quoteCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Media Section: Videos | Articles | Books -->
    <div class="w-100 bg-light py-5">
        <div class="container">
            <div class="row text-center">
                <!-- Books -->
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-4 bg-white rounded shadow h-100">
                        <i class="bi bi-book display-4 text-danger mb-3"></i>
                        <h4 class="fw-bold">Books</h4>
                        <p>Browse through a collection of recommended books on astronomy, astrophysics, and the cosmos.</p>
                        <a href="../views/BookPage.php" class="btn btn-outline-danger mt-2">Browse Books →</a>
                    </div>
                </div>


                <!-- Articles -->
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="p-4 bg-white rounded shadow h-100">
                        <i class="bi bi-journal-text display-4 text-success mb-3"></i>
                        <h4 class="fw-bold">Articles</h4>
                        <p>Read insightful articles and space discoveries written by experts and astronomy enthusiasts.</p>
                        <a href="../views/ArticlePage.php" class="btn btn-outline-success mt-2">Read More →</a>
                    </div>
                </div>

                <!-- Videos -->
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="p-4 bg-white rounded shadow h-100">
                        <i class="bi bi-play-circle display-4 text-primary mb-3"></i>
                        <h4 class="fw-bold">Videos</h4>
                        <p>Watch educational and fascinating videos about the universe, planets, stars, and space missions.</p>
                        <a href="../views/VideoPage.php" class="btn btn-outline-primary mt-2">Watch Now →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Observatories -->
    <div class="container my-5">
        <!-- Hàng ảnh ngang -->
        <div class="row g-3 justify-content-center mb-4">
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="100">
                <img src="../assets/images/observatory-home-1.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 1">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="200">
                <img src="../assets/images/observatory-home-2.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 2">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="300">
                <img src="../assets/images/observatory-home-3.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 3">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="400">
                <img src="../assets/images/observatory-home-4.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 4">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="500">
                <img src="../assets/images/observatory-home-5.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 5">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="600">
                <img src="../assets/images/observatory-home-6.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 5">
            </div>
        </div>

        <div class="row g-3 justify-content-center mb-4">
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="700">
                <img src="../assets/images/observatory-home-9.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 1">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="800">
                <img src="../assets/images/observatory-home-8.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 2">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="900">
                <img src="../assets/images/observatory-home-10.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 3">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="1000">
                <img src="../assets/images/observatory-home-11.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 4">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="1100">
                <img src="../assets/images/observatory-home-7.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 5">
            </div>
            <div class="col-6 col-sm-4 col-md-2" data-aos="flip-left" data-aos-delay="1200">
                <img src="../assets/images/observatory-home-12.jpg" class="img-fluid rounded shadow-sm" alt="Observatory 5">
            </div>
        </div>

        <!-- Phần thông tin -->
        <div class="text-center px-3" data-aos="zoom-in" data-aos-delay="350">
            <h2 class="fw-bold mb-3">Astronomical Observatories</h2>
            <p class="lead mb-4">
                Observatories are equipped with powerful telescopes and instruments that allow scientists to observe distant galaxies, stars, and planets.
                Dive into the world of astronomy and discover the secrets of the universe.
            </p>
            <a href="../views/ObservatoryPage.php" class="btn btn-outline-dark">View Observatories →</a>
        </div>
    </div>

    <!-- Footer -->
    <div>
        <?php include('includes/Footer.php'); ?>
    </div>

    <!-- Bootstrap -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/simple-notification.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>