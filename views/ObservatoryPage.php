<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Space Dot Com | Observatory</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <style>
        body {
            background: #0d1b2a;
            color: #e0e6f2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
            padding-top: 60px;
        }
        .page-header {
            text-align: center;
            padding: 2rem 0;
            border-bottom: 2px solid #415a77;
        }
        .page-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            color: #fca311;
        }
        .page-description {
            max-width: 700px;
            margin: 1rem auto 3rem;
            font-size: 1.2rem;
            color: #adb5bd;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include('../includes/Header.php'); ?>
    </header>

    <!-- Main Content -->
    <main class="container">
        <section class="page-header">
            <h1><i class="bi bi-binoculars"></i> Observatory</h1>
            <p class="page-description">
                Explore the wonders of the universe. Discover celestial events, star maps, and the latest space observations.
            </p>
        </section>

        <!-- Observatory content area -->
        <section>
    <div class="text-center">
        <img src="/assets/images/observatory-night.jpg" alt="Observatory at Night" class="img-fluid rounded shadow" style="max-width: 600px;" />
    </div>
    <p class="mt-4 text-center">
        Our observatory offers detailed views of the night sky and regular updates on astronomical phenomena.
    </p>
</section>

    </main>

    <!-- Footer -->
    <footer>
        <?php include('../includes/Footer.php'); ?>
    </footer>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
