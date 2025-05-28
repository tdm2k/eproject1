<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/PlanetController.php';
$controller = new PlanetController();
$response = $controller->getDeletedPlanets();
$planets = $response['status'] === 'success' ? $response['data'] : [];
$error_message = $response['status'] === 'error' ? $response['message'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Planets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .main-page-content {
            margin-left: 280px;
        }
    </style>
</head>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>
        <main class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Deleted Planets</h3>
                            <a href="AdminPlanet.php" class="btn btn-secondary">Back to Active Planets</a>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($_GET['error']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_GET['success'])): ?>
                                <div class="alert alert-success">
                                    <?php echo htmlspecialchars($_GET['success']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($planets)): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($planets as $planet): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($planet->getId()); ?></td>
                                                    <td><?php echo htmlspecialchars($planet->getName()); ?></td>
                                                    <td>
                                                        <?php if ($planet->getImage()): ?>
                                                            <img src="../<?php echo htmlspecialchars($planet->getImage()); ?>" alt="<?php echo htmlspecialchars($planet->getName()); ?>" class="rounded-circle object-fit-cover" style="width: 100px; height: 100px;">
                                                        <?php else: ?>
                                                            <p class="text-muted">No image available</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="../controllers/PlanetController.php?action=restore&id=<?php echo $planet->getId(); ?>"
                                                                class="btn btn-success btn-sm me-3"
                                                                onclick="return confirm('Are you sure you want to restore this planet?')">
                                                                <i class="fas fa-undo"></i> Restore
                                                            </a>
                                                            <a href="../controllers/PlanetController.php?action=forceDelete&id=<?php echo $planet->getId(); ?>"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to permanently delete this planet? This action cannot be undone.')">
                                                                <i class="fas fa-trash"></i> Delete Permanently
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No deleted planets found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="mt-auto">
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>