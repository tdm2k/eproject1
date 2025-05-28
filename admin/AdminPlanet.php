<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/PlanetController.php';
$controller = new PlanetController();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$response = $controller->index();
$paginationData = $response['status'] === 'success' ? $response['data'] : null;
$planets = $paginationData ? $paginationData['planets'] : [];
$error_message = $response['status'] === 'error' ? $response['message'] : null;

// Thông báo từ query string
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
$error = $_GET['error'] ?? null;
$errorMessages = [
    'invalid-action' => 'Invalid action specified.',
    'invalid-request-method' => 'Invalid request method.',
    'empty-planet-name' => 'Planet name cannot be empty.',
    'invalid-planet-id' => 'Invalid planet ID.',
    'invalid-file-type' => 'Invalid file type. Only JPG, PNG and GIF are allowed.',
    'file-too-large' => 'File is too large. Maximum size is 5MB.',
    'upload-failed' => 'Failed to upload file.',
    'add-failed' => 'Failed to add planet.',
    'update-failed' => 'Failed to update planet.',
    'delete-failed' => 'Failed to delete planet.',
    'restore-failed' => 'Failed to restore planet.',
    'unknown-error' => 'An unknown error occurred.'
];

$successMessages = [
    'planet-added' => 'Planet added successfully!',
    'planet-updated' => 'Planet updated successfully!',
    'planet-deleted' => 'Planet deleted successfully!',
    'planet-restored' => 'Planet restored successfully!',
    'planet-permanently-deleted' => 'Planet permanently deleted!'
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
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <!-- CSS -->
    <style>
        .main-page-content {
            margin-left: 280px;
        }

        .categories-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .action-column {
            text-align: right;
            white-space: nowrap;
        }

        .success-notification {
            position: fixed;
            top: auto;
            bottom: 20px;
            left: auto;
            right: 20px;
            z-index: 1055;
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .success-notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        .error-notification {
            position: fixed;
            top: auto;
            bottom: 20px;
            left: auto;
            right: 20px;
            z-index: 1055;
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .error-notification.show {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4">

            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-4">Planets Management</h1>
                    <div>
                        <a href="PlanetForm.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New Planet
                        </a>
                        <a href="PlanetTrash.php" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Trash
                        </a>
                    </div>
                </div>

                <?php

                if (isset($_GET['error']) && isset($errorMessages[$_GET['error']])): ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?= $errorMessages[$_GET['error']] ?>
                    </div>
                <?php endif; ?>

                <?php

                if (isset($_GET['success']) && isset($successMessages[$_GET['success']])): ?>
                    <div class="alert alert-success success-notification show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= $successMessages[$_GET['success']] ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <!-- Bảng dữ liệu -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($planets)): ?>
                                <?php foreach ($planets as $planet): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($planet->getId()); ?></td>
                                        <td>
                                            <?php if ($planet->getImage()): ?>
                                                <img src="../<?php echo htmlspecialchars($planet->getImage()); ?>"
                                                    alt="<?php echo htmlspecialchars($planet->getName()); ?>"
                                                    class="rounded-circle object-fit-cover" style="width: 120px; height: 120px;">
                                            <?php else: ?>
                                                <img src="../assets/images/no-image.png"
                                                    alt="No image"
                                                    class="img-thumbnail"
                                                    class="rounded-circle object-fit-cover" style="width: 100px; height: 100px;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($planet->getName()); ?></td>
                                        <td><?php echo htmlspecialchars($planet->getCategoryName()); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="PlanetEdit.php?id=<?php echo $planet->getId(); ?>"
                                                    class="btn btn-primary btn-sm me-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="../controllers/PlanetController.php?action=delete&id=<?php echo $planet->getId(); ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this planet?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No planets found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <?php if ($paginationData): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($paginationData['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $paginationData['current_page'] - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </span>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $paginationData['total_pages']; $i++): ?>
                                <li class="page-item <?php echo $i === $paginationData['current_page'] ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($paginationData['current_page'] < $paginationData['total_pages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $paginationData['current_page'] + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto">
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </footer>
    </div>

    <!-- Bootstrap -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
</body>

</html>