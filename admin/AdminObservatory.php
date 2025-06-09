<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/ObservatoryController.php';

$controller = new ObservatoryController();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$response = $controller->index();
$paginationData = $response['status'] === 'success' ? $response['data'] : null;
$observatories = $paginationData ? $paginationData['observatories'] : [];
$error_message = $response['status'] === 'error' ? $response['message'] : null;

// Debug log
error_log("Full response: " . print_r($response, true));

// Initialize variables
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = 1;
$totalItems = 0;

// Safely check response structure
if (is_array($response) && isset($response['status']) && $response['status'] === 'success') {
    if (isset($response['data']['observatories'])) {
        $observatories = $response['data']['observatories'];
    }
    if (isset($response['data']['total_pages'])) {
        $totalPages = (int)$response['data']['total_pages'];
    }
    if (isset($response['data']['total'])) {
        $totalItems = (int)$response['data']['total'];
    }
}

// Debug log pagination data
error_log("Pagination data - Current page: $currentPage, Total pages: $totalPages, Total items: $totalItems");
error_log("Observatories count: " . count($observatories));

// Get status and error messages from URL parameters
$status = $_GET['status'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;

// Define notification messages
$errorMessages = [
    'empty-observatory-name' => 'Observatory name cannot be empty.',
    'empty-observatory-location' => 'Observatory location cannot be empty.',
    'invalid-observatory-id' => 'Invalid observatory ID.',
    'observatory-not-found' => 'Observatory not found.',
    'failed-to-add' => 'Failed to add observatory.',
    'update-failed' => 'Failed to update observatory.',
    'delete-failed' => 'Failed to delete observatory.',
    'invalid-file-type' => 'Invalid file type. Only JPG, PNG and GIF are allowed.',
    'file-too-large' => 'File is too large. Maximum size is 5MB.',
    'upload-failed' => 'Failed to upload file.',
    'invalid-action' => 'Invalid action specified.',
    'invalid-request-method' => 'Invalid request method.'
];

$successMessages = [
    'observatory-added' => 'Observatory added successfully!',
    'observatory-updated' => 'Observatory updated successfully!',
    'observatory-deleted' => 'Observatory deleted successfully!'
];

// Debug information
error_log("Response data: " . print_r($response, true));
error_log("Observatories data: " . print_r($observatories, true));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin - Observatories</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <style>
        .main-page-content {
            margin-left: 280px;
        }

        .table-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
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

        /* Pagination styles */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            color: #0d6efd;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.875rem;
        }

        /* Card hover effect styles */
        .card {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .card-body {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include 'includes/AdminSidebar.php'; ?>

        <main class="flex-grow-1 p-4">
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-4">Observatories Management</h1>
                    <a href="ObservatoryForm.php" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add New Observatory
                    </a>
                </div>

                <?php if (isset($_GET['error']) && isset($errorMessages[$_GET['error']])): ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?= $errorMessages[$_GET['error']] ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && isset($successMessages[$_GET['success']])): ?>
                    <div class="alert alert-success success-notification show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= $successMessages[$_GET['success']] ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($observatories)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($observatories as $observatory): ?>
                                    <tr>
                                        <td><?= is_object($observatory) ? $observatory->getId() : 'N/A' ?></td>
                                        <td>
                                            <?php if (is_object($observatory) && $observatory->getImageUrl()): ?>
                                                <img src="../<?= htmlspecialchars($observatory->getImageUrl()) ?>"
                                                    alt="<?= htmlspecialchars($observatory->getName()) ?>"
                                                    class="table-image">
                                            <?php else: ?>
                                                <img src="../assets/images/no-image.png"
                                                    alt="No image"
                                                    class="table-image">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= is_object($observatory) ? htmlspecialchars($observatory->getName()) : 'N/A' ?></td>
                                        <td><?= is_object($observatory) ? nl2br(html_entity_decode($observatory->getLocation())) : 'N/A' ?></td>
                                        <td>
                                            <?php if (is_object($observatory)): ?>
                                               <div class="btn-group">
                                                 <a href="ObservatoryEdit.php?id=<?= $observatory->getId() ?>"
                                                    class="btn btn-primary btn-sm me-2">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete(<?= $observatory->getId() ?>)">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                               </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
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
                <?php else: ?>
                    <div class="text-center">
                        <p class="text-muted">No observatories found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto">
            <?php include 'includes/AdminFooter.php'; ?>
        </footer>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this observatory?')) {
                // Preserve the current page number when deleting
                const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
                window.location.href = '../controllers/ObservatoryController.php?action=delete&id=' + id + '&page=' + currentPage;
            }
        }
    </script>
</body>

</html>