<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/VideoController.php';

$controller = new VideoController();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$response = $controller->index();
$paginationData = $response['status'] === 'success' ? $response['data'] : null;
$videos = $paginationData ? $paginationData['videos'] : [];
$error_message = $response['status'] === 'error' ? $response['message'] : null;

// Debug log
error_log("Full response: " . print_r($response, true));

// Initialize variables
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = 1;
$totalItems = 0;

// Safely check response structure
if (is_array($response) && isset($response['status']) && $response['status'] === 'success') {
    if (isset($response['data']['videos'])) {
        $videos = $response['data']['videos'];
    }
    if (isset($response['data']['total_pages'])) {
        $totalPages = (int)$response['data']['total_pages'];
    }
    if (isset($response['data']['total'])) {
        $totalItems = (int)$response['data']['total'];
    }
}

// Get status and error messages from URL parameters
$status = $_GET['status'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;

// Define notification messages
$errorMessages = [
    'empty-video-title' => 'Video title cannot be empty.',
    'empty-video-url' => 'Video URL cannot be empty.',
    'invalid-video-id' => 'Invalid video ID.',
    'video-not-found' => 'Video not found.',
    'failed-to-add' => 'Failed to add video.',
    'update-failed' => 'Failed to update video.',
    'delete-failed' => 'Failed to delete video.',
    'invalid-file-type' => 'Invalid file type. Only JPG, PNG and GIF are allowed.',
    'file-too-large' => 'File is too large. Maximum size is 5MB.',
    'upload-failed' => 'Failed to upload file.',
    'invalid-action' => 'Invalid action specified.',
    'invalid-request-method' => 'Invalid request method.'
];

$successMessages = [
    'video-added' => 'Video added successfully!',
    'video-updated' => 'Video updated successfully!',
    'video-deleted' => 'Video deleted successfully!'
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin - Videos</title>
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

        .success-notification,
        .error-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1055;
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .success-notification.show,
        .error-notification.show {
            opacity: 1;
            transform: translateX(0);
        }

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
        <?php include 'includes/AdminSidebar.php'; ?>
        <main class="flex-grow-1 p-4">
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-4">Videos Management</h1>
                    <a href="VideoForm.php" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add New Video
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

                <?php if (!empty($videos)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Thumbnail</th>
                                    <th>Title</th>
                                    <th>URL</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($videos as $video): ?>
                                    <tr class="align-middle">
                                        <td><?= is_object($video) ? $video->getId() : 'N/A' ?></td>
                                        <td>
                                            <?php
                                            $thumb = $video->getThumbnailUrl();
                                            $autoThumb = $video->getAutoThumbnail();

                                            if (!empty($thumb) && file_exists(__DIR__ . '/../uploads/thumbnails/' . $thumb)) {
                                                $imgSrc = '../uploads/thumbnails/' . htmlspecialchars($thumb);
                                            } elseif (!empty($autoThumb)) {
                                                $imgSrc = $autoThumb;
                                            } else {
                                                $imgSrc = 'https://via.placeholder.com/400x190?text=No+Thumbnail';
                                            }
                                            ?>

                                            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($video->getTitle()) ?>" loading="lazy" />
                                        </td>
                                        <td class="fw-semibold"><?= is_object($video) ? htmlspecialchars($video->getTitle()) : 'N/A' ?></td>
                                        <td style="max-width: 300px; word-break: break-word;" class="text-muted">
                                            <?= is_object($video) ? htmlspecialchars($video->getVideoUrl()) : 'N/A' ?>
                                        </td>
                                        <td>
                                            <?php if (is_object($video)): ?>
                                                <div class="btn-group" role="group">
                                                    <a href="VideoEdit.php?id=<?= $video->getId() ?>"
                                                        class="btn btn-primary btn-sm d-flex align-items-center me-2">
                                                        <i class="bi bi-pencil me-1"></i> Edit
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm d-flex align-items-center"
                                                        onclick="confirmDelete(<?= $video->getId() ?>)">
                                                        <i class="bi bi-trash me-1"></i> Delete
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($paginationData): ?>
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php if ($paginationData['current_page'] > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $paginationData['current_page'] - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link" aria-label="Previous">&laquo;</span>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $paginationData['total_pages']; $i++): ?>
                                    <li class="page-item <?= $i === $paginationData['current_page'] ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($paginationData['current_page'] < $paginationData['total_pages']): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $paginationData['current_page'] + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link" aria-label="Next">&raquo;</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center">
                        <p class="text-muted">No videos found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <footer class="mt-auto">
            <?php include 'includes/AdminFooter.php'; ?>
        </footer>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this video?')) {
                const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
                window.location.href = '../controllers/VideoController.php?action=delete&id=' + id + '&page=' + currentPage;
            }
        }
    </script>
</body>

</html>