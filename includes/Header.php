<?php
$currentPageName = strtolower(basename($_SERVER['SCRIPT_NAME'], '.php'));
$hideSearchOnPages = ['loginpage', 'registerpage', 'changepasswordpage', 'resetpasswordpage', 'userprofilepage']; // dùng chữ thường
$showSearchBar = !in_array($currentPageName, $hideSearchOnPages);
?>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-secondary fixed-top">
    <div class="container">
        <a class="navbar-brand me-5" href="../index.php"><img src="../assets/images/space-com-black-small.png" height="50"></a>
        <?php if ($showSearchBar): ?>
            <form class="d-flex mx-auto" role="search" action="/search-results.php" method="GET" style="max-width: 500px; width: 100%;">
                <input class="form-control me-2" type="search" placeholder="Search for planets, constellations, comets..." aria-label="Search" name="q">
            </form>
        <?php endif; ?>
        <!-- Lưu ý: action="/search-results.php" và name="q" chỉ là ví dụ -->

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCatalogueLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Catalogue Menu">
                        <i class="bi bi-stack"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownCatalogueLink">
                        <a class="dropdown-item" href="../views/PlanetPage.php">🪐 Planets</a>
                        <a class="dropdown-item" href="../views/ConstellationPage.php">🌌 Constellations</a>
                        <a class="dropdown-item" href="../views/CometPage.php">☄️ Comets</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../views/ArticlePage.php">📰 Articles</a>
                        <a class="dropdown-item" href="../views/VideoPage.php">🎥 Videos</a>
                        <a class="dropdown-item" href="../views/BookPage.php">📖 Books</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../views/ObservatoryPage.php">🔭 Observatories</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/AboutUsPage.php">About Us</a>
                </li>

                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_fullname'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUserLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['user_fullname']); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUserLink">
                            <a class="dropdown-item" href="../views/UserProfilePage.php">My Profile</a>
                            <a class="dropdown-item" href="../views/ChangePasswordPage.php">Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../controllers/UserController.php?action=logout">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/RegisterPage.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/LoginPage.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>