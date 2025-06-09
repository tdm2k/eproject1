<?php
require_once __DIR__ . '/../models/ConstellationModel.php';
$model = new ConstellationModel();
$constellations = $model->getAllConstellations();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Space Dot Com | Constellations</title>
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
<style>
  .bg-constellation {
    background-image: url('https://png.pngtree.com/thumb_back/fw800/back_our/20190622/ourmid/pngtree-fantasy-starry-sky-12-constellations-background-image_219283.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    color: white;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.8);
  }
  .bg-constellation .overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 0;
  }
  .bg-constellation .container {
    position: relative;
    z-index: 1;
    text-align: center;
  }

  .constellation-intro {
    padding: 60px 0;
  }
  .constellation-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 30px;
  }
  .constellation-card {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    height: 350px;
    cursor: pointer;
    background: #fff;
    box-shadow: 0 6px 15px rgb(0 0 0 / 0.1);
    transition: 0.5s box-shadow;
    display: flex;
    flex-direction: column;
  }
  .constellation-card:hover {
    box-shadow: 0 10px 25px rgb(0 0 0 / 0.25);
  }
  .constellation-card img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    transition: 0.5s transform;
    border-radius: 16px 16px 0 0;
  }
  .constellation-card:hover img {
    transform: scale(1.05);
  }
  .constellation-card .layer {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 75%;
    background: linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0));
    opacity: 0;
    transition: 0.3s;
  }
  .constellation-card .info {
    position: absolute;
    bottom: -50%;
    left: 0;
    right: 0;
    padding: 15px;
    color: white;
    opacity: 0;
    transition: 0.5s bottom, 1.5s opacity;
  }
  .constellation-card:hover .layer {
    opacity: 1;
  }
  .constellation-card:hover .info {
    bottom: 0;
    opacity: 1;
  }
  .constellation-group:hover .constellation-card:not(:hover) {
    filter: blur(3px);
  }
  .info h5 {
    margin-bottom: 0.75rem;
  }
  .info p {
    font-size: 0.9rem;
    line-height: 1.3;
  }
</style>
</head>
<body>
<?php include('../includes/Header.php'); ?>

<section class="bg-constellation" data-aos="fade-down">
  <div class="overlay"></div>
  <div class="container">
    <h1 class="display-4 fw-bold">Constellations</h1>
    <p class="lead">Explore constellations and the fascinating stories of the universe.</p>
  </div>
</section>

<main class="mb-5">
  <section class="constellation-intro">
    <div class="container">
      <h2 class="display-5 fw-bold mb-3 text-primary" data-aos="fade-up">What are Constellations?</h2>
      <p class="fs-5" data-aos="fade-up" data-aos-delay="100">
        Constellations are groups of stars arranged in specific patterns or shapes in the sky, helping observers easily recognize and locate positions in the celestial sphere. Each constellation is often associated with unique legends and cultural meanings across various civilizations.
      </p>
      <p class="fs-6 text-muted mt-3" data-aos="fade-up" data-aos-delay="200">
        The study and classification of constellations not only aid astronomers in navigating the night sky but also serve as a bridge between science and culture, opening doors to fascinating cosmic discoveries.
      </p>
    </div>
  </section>

  <section>
    <div class="container">
      <?php if (!empty($constellations)): ?>
      <div class="constellation-group" data-aos="fade-up" data-aos-delay="200">
        <?php foreach ($constellations as $c): ?>
        <div class="constellation-card">
          <a href="ConstellationDetail.php?id=<?= $c['id'] ?>" style="color: inherit; text-decoration: none; display: block; height: 100%; position: relative;">
            <?php if (!empty($c['image'])): ?>
              <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" loading="lazy" decoding="async" />
            <?php else: ?>
              <img src="https://via.placeholder.com/400x190?text=No+Image" alt="No image" />
            <?php endif; ?>
            <div class="layer"></div>
            <div class="info">
              <h5><?= htmlspecialchars($c['name']) ?></h5>
              <p>
                <?php
                $desc = strip_tags($c['description']);
                echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                ?>
              </p>
              <span class="btn btn-sm btn-light mt-2">View Details</span>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
        <p class="text-muted text-center">No constellation data available.</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php include('../includes/Footer.php'); ?>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
