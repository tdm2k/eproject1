<?php
session_start();
$currentPageName = strtolower(basename($_SERVER['SCRIPT_NAME'], '.php'));
$hideSearchOnPages = ['loginpage', 'registerpage', 'changepasswordpage', 'resetpasswordpage', 'userprofilepage'];
$showSearchBar = !in_array($currentPageName, $hideSearchOnPages);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Space Project - Team 5</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #0d1b2a;
            color: #e0e1dd;
            font-family: 'Segoe UI', sans-serif;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        header {
            text-align: center;
            padding: 60px 20px 20px;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1.2rem;
            color: #a9bcd0;
        }

        .project-description {
            text-align: center;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #d9e2ec;
        }

        .team-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 40px 20px;
        }

        .member-card {
            background-color: rgba(30, 58, 95, 0.85);
            border-radius: 15px;
            padding: 20px;
            width: 250px;
            text-align: center;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            transition: transform 0.3s;
        }

        .member-card:hover {
            transform: scale(1.05);
        }

        .member-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 2px solid #fff;
        }

        .footer {
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <!-- Particles background -->
    <div id="particles-js"></div>

    <?php include '../includes/Header.php'; ?>

    <!-- Main Content -->
    <main class="flex-grow-1 pt-5 mt-5">
        <header>
            <h1>Team 4: Universe Exploration Project</h1>
            <p>Discovering the Beauty of the Stars - A Collaboration of Passionate Developers</p>
        </header>

        <section class="project-description">
            <p>
                Our project is centered around visualizing and sharing knowledge about constellations in the universe. Users can explore well-known constellations such as Orion, Ursa Major, and more, while learning interesting facts and stories behind each celestial formation.
            </p>
        </section>

        <section class="team-section">
            <?php
            $members = [
                ["img" => 1, "name" => "Đỗ Trung Hiếu", "role" => "Team Leader"],
                ["img" => 2, "name" => "Trần Đăng Minh", "role" => ""],
                ["img" => 3, "name" => "Đặng Quang Kỳ", "role" => ""],
                ["img" => 4, "name" => "Nguyễn Tiến Huy", "role" => ""],
                ["img" => 5, "name" => "Nguyễn Tất Đạt", "role" => ""]
            ];
            foreach ($members as $m): ?>
                <div class="member-card">
                    <img src="https://i.pravatar.cc/150?img=<?= $m['img'] ?>" alt="<?= $m['name'] ?>">
                    <h3><?= $m['name'] ?></h3>
                    <p><?= $m['role'] ?></p>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <!-- Footer -->
    <div class="footer">
        <?php include '../includes/Footer.php'; ?>
    </div>

    <!-- JavaScript -->
    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 100
                },
                color: {
                    value: "#ffffff"
                },
                shape: {
                    type: "circle"
                },
                opacity: {
                    value: 0.5
                },
                size: {
                    value: 2
                },
                line_linked: {
                    enable: true,
                    distance: 120,
                    color: "#ffffff",
                    opacity: 0.3,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 0.8
                }
            },
            interactivity: {
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    }
                }
            },
            retina_detect: true
        });

        function updateLiveClock() {
            const clockElement = document.getElementById('live-clock');
            if (clockElement) {
                const now = new Date();
                clockElement.textContent = now.toLocaleString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }
        }
        updateLiveClock();
        setInterval(updateLiveClock, 1000);
    </script>
</body>

</html>