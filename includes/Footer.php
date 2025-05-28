<footer class="footer bg-dark text-white pt-5 pb-3 mt-auto rounded-top shadow-lg">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>About Space.com</h5>
                <p>We bring the wonders of the universe closer to you. Explore planets, constellations, comets, and beyond.</p>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Quick Links</h5>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><a href="../views/PlanetPage.php" class="text-white text-decoration-none">Planets</a></li>
                            <li><a href="../views/ConstellationPage.php" class="text-white text-decoration-none">Constellations</a></li>
                            <li><a href="../views/CometPage.php" class="text-white text-decoration-none">Comets</a></li>
                            <li><a href="../views/ObservatoryPage.php" class="text-white text-decoration-none">Observatories</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><a href="../views/ArticlePage.php" class="text-white text-decoration-none">Articles</a></li>
                            <li><a href="../views/BookPage.php" class="text-white text-decoration-none">Books</a></li>
                            <li><a href="../views/VideoPage.php" class="text-white text-decoration-none">Videos</a></li>
                            <li><a href="../views/AboutUsPage.php" class="text-white text-decoration-none">About Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Contact</h5>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-2">
                        <i class="bi bi-envelope-fill me-2"></i> <span>Email: info@space.com</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="bi bi-phone-fill me-2"></i> <span>Phone: +123 456 789</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="bi bi-clock-fill me-2"></i> <span>Live Clock: <span id="live-clock"></span></span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary">

        <p class="text-center mb-0">
            &copy; <?php echo date('Y'); ?> Space.com. All rights reserved.
        </p>
    </div>
</footer>

<script>
    function updateLiveClock() {
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            const now = new Date();
            const options = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            };
            clockElement.textContent = now.toLocaleString('en-US', options); // Hoặc 'vi-VN' nếu muốn định dạng tiếng Việt
        }
    }
    updateLiveClock();
    setInterval(updateLiveClock, 1000);
</script>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;
    }

    .footer {
        flex-shrink: 0;
    }
</style>