<?php
require_once '../models/AdminDashboardModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
    }
}

$adminDashboardModel = new AdminDashboardModel();
$userCount = $adminDashboardModel->getUserCount();
$planetCount = $adminDashboardModel->getPlanetCount();
$constellationCount = $adminDashboardModel->getConstellationCount();
$cometCount = $adminDashboardModel->getCometCount();
$articleCount = $adminDashboardModel->getArticleCount();
$videoCount = $adminDashboardModel->getVideoCount();
$bookCount = $adminDashboardModel->getBookCount();
$observatoryCount = $adminDashboardModel->getObservatoryCount();

$items = [
    ['icon' => 'bi-people', 'title' => 'Users', 'count' => $userCount, 'url' => '../admin/AdminUser.php'],
    ['icon' => 'bi-globe', 'title' => 'Planets', 'count' => $planetCount, 'url' => '../admin/AdminPlanet.php'],
    ['icon' => 'bi-stars', 'title' => 'Constellations', 'count' => $constellationCount, 'url' => '../admin/AdminConstellation.php'],
    ['icon' => 'bi-star', 'title' => 'Comets', 'count' => $cometCount, 'url' => '../admin/AdminComet.php'],
    ['icon' => 'bi-newspaper', 'title' => 'Articles', 'count' => $articleCount, 'url' => '../admin/AdminArticle.php'],
    ['icon' => 'bi-camera-video', 'title' => 'Videos', 'count' => $videoCount, 'url' => '../admin/AdminVideo.php'],
    ['icon' => 'bi-book', 'title' => 'Books', 'count' => $bookCount, 'url' => '../admin/AdminBook.php'],
    ['icon' => 'bi-binoculars', 'title' => 'Observatories', 'count' => $observatoryCount, 'url' => '../admin/AdminObservatory.php'],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin</title>
    <!-- Bootstrap -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .main-page-content {
            margin-left: 280px;
        }

        .card-hover-effect {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card-hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="bg-light">
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <main class="flex-grow-1 p-4">
            <div class="container-fluid">
                <h2 class="fw-bold text-dark mb-4">Dashboard</h2>
                <div class="row row-cols-2 row-cols-md-4 g-3 mb-5 border-bottom pb-3">
                    <?php foreach ($items as $item): ?>
                        <div class="col">
                            <div class="border rounded text-center py-4 bg-white shadow-sm h-100 position-relative card-hover-effect">
                                <i class="bi <?= $item['icon'] ?> fs-2 text-success mb-2"></i>
                                <h6 class="mb-0 text-dark"><?= $item['title'] ?></h6>
                                <div class="text-muted"><?= number_format($item['count']) ?> entries</div>
                                <a href="<?= $item['url'] ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Chart -->
                <div class="card mt-5 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Weekly visits chart</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="timePeriodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Week
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="timePeriodDropdown">
                                <li><a class="dropdown-item" href="#" data-period="day">Day</a></li>
                                <li><a class="dropdown-item active" href="#" data-period="week">Week</a></li>
                                <li><a class="dropdown-item" href="#" data-period="month">Month</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart" height="350"></canvas>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto">
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('lineChart').getContext('2d');
        let myChart;

        const dataDay = {
            labels: ['1 AM', '4 AM', '7 AM', '10 AM', '1 PM', '4 PM', '7 PM', '10 PM'],
            datasets: [{
                label: 'Doanh thu',
                data: [5000, 7000, 10000, 12000, 15000, 13000, 9000, 6000],
                fill: false,
                borderColor: '#0d6efd',
                backgroundColor: '#0d6efd',
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        };

        const dataWeek = {
            labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            datasets: [{
                label: 'Doanh thu',
                data: [15500, 21500, 18000, 24000, 23500, 24300, 12000],
                fill: false,
                borderColor: '#0d6efd',
                backgroundColor: '#0d6efd',
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        };

        const dataMonth = {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Doanh thu',
                data: [80000, 95000, 75000, 110000],
                fill: false,
                borderColor: '#0d6efd',
                backgroundColor: '#0d6efd',
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        };

        function updateChart(period) {
            let newData;
            let newLabel;
            switch (period) {
                case 'day':
                    newData = dataDay;
                    newLabel = 'Daily visits chart';
                    break;
                case 'week':
                    newData = dataWeek;
                    newLabel = 'Weekly visits chart';
                    break;
                case 'month':
                    newData = dataMonth;
                    newLabel = 'Monthly visits chart';
                    break;
            }

            if (myChart) {
                myChart.destroy(); // Hủy biểu đồ cũ nếu có
            }
            myChart = new Chart(ctx, {
                type: 'line',
                data: newData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#333'
                            },
                            grid: {
                                color: '#eee'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#333',
                                callback: value => value.toLocaleString()
                            },
                            grid: {
                                color: '#eee'
                            },
                            beginAtZero: false
                        }
                    }
                }
            });
            document.querySelector('.card-header h5').textContent = newLabel;
        }

        updateChart('week');

        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();

                document.getElementById('timePeriodDropdown').textContent = this.textContent;

                document.querySelectorAll('.dropdown-item').forEach(el => el.classList.remove('active'));
                this.classList.add('active');

                const period = this.getAttribute('data-period');
                updateChart(period);
            });
        });
    </script>
</body>

</html>