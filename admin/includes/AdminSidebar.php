<?php
$currentPage = strtolower(basename($_SERVER['SCRIPT_NAME'], '.php'));
$isDashboard = ($currentPage == 'dashboard');
?>

<div class="position-fixed top-0 start-0 vh-100 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;" data-bs-theme="dark">
    <a class="navbar-brand me-auto mb-3" href="/admin/Dashboard.php"><img src="../assets/images/space-com-gray-small.png" height="45"></a>
    <hr class="mt-1">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/admin/Dashboard.php" class="nav-link <?php echo $isDashboard ? 'active' : 'text-white'; ?>" <?php echo $isDashboard ? 'aria-current="page"' : ''; ?>>
                <i class="bi bi-ui-checks-grid me-2"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/AdminPlanet.php" class="nav-link <?php echo ($currentPage == 'adminplanet' || $currentPage == 'planetedit' || $currentPage == 'planetform' || $currentPage == 'planettrash') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-globe me-2"></i>
                Planets
            </a>
        </li>
        <li>
            <a href="/admin/AdminConstellation.php" class="nav-link <?php echo ($currentPage == 'adminconstellation') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-stars me-2"></i>
                Constellations
            </a>
        </li>
        <li>
            <a href="/admin/AdminComet.php" class="nav-link <?php echo ($currentPage == 'admincomet') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-star me-2"></i>
                Comets
            </a>
        </li>
        <li>
            <a href="/admin/AdminArticle.php" class="nav-link <?php echo ($currentPage == 'adminarticle') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-newspaper me-2"></i>
                Articles
            </a>
        </li>
        <li>
            <a href="/admin/AdminVideo.php" class="nav-link <?php echo ($currentPage == 'adminvideo') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-camera-video me-2"></i>
                Videos
            </a>
        </li>
        <li>
            <a href="/admin/AdminBook.php" class="nav-link <?php echo ($currentPage == 'adminbook' || $currentPage == 'bookedit' || $currentPage == 'bookform') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-book me-2"></i>
                Books
            </a>
        </li>
        <li>
            <a href="/admin/AdminObservatory.php" class="nav-link <?php echo ($currentPage == 'adminobservatory') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-binoculars me-2"></i>
                Observatories
            </a>
        </li>
        <li>
            <a href="/admin/AdminCategory.php" class="nav-link <?php echo ($currentPage == 'admincategory') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-tags me-2"></i>
                Categories
            </a>
        </li>
        <li>
            <a href="/admin/AdminUser.php" class="nav-link <?php echo ($currentPage == 'adminuser') ? 'active' : 'text-white'; ?>">
                <i class="bi bi-people-fill me-2"></i>
                Users
            </a>
        </li>
    </ul>

    <div class="mt-auto pt-2">
        <hr>
        <a href="../controllers/UserController.php?action=logout" class="nav-link text-white">
            <i class="bi bi-box-arrow-right me-2"></i>
            Sign out
        </a>
    </div>

</div>