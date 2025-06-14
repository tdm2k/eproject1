<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/VideoController.php';

// $controller = new VideoController(); // không cần dùng ở đây

$errorMessages = [
    'invalid-action' => 'Invalid action specified.',
    'invalid-request-method' => 'Invalid request method.',
    'empty-video-title' => 'Video title cannot be empty.',
    'invalid-video-id' => 'Invalid video ID.',
    'invalid-file-type' => 'Invalid file type. Only JPG, PNG and GIF are allowed.',
    'file-too-large' => 'File is too large. Maximum size is 5MB.',
    'upload-failed' => 'Failed to upload file.',
    'failed-to-add' => 'Failed to add video.'
];

$successMessages = [
    'video-added' => 'Video added successfully!'
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Video</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <style>
        .main-page-content {
            margin-left: 250px;
            padding: 20px;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 4px;
            margin-top: 10px;
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
                    <h2>Add New Video</h2>
                    <a href="AdminVideo.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Videos
                    </a>
                </div>

                <?php if (isset($_GET['error']) && isset($errorMessages[$_GET['error']])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $errorMessages[$_GET['error']] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && isset($successMessages[$_GET['success']])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $successMessages[$_GET['success']] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form action="../controllers/VideoController.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="action" value="add">

                            <div class="mb-3">
                                <label for="title" class="form-label">Video Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required maxlength="255">
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label">Video URL *</label>
                                <input type="url" class="form-control" id="url" name="url" required maxlength="500">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" maxlength="1000"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/gif" onchange="previewImage(this)">
                                <div id="imagePreviewContainer" class="mt-2"></div>
                                <small class="text-muted">Maximum file size: 5MB. Only JPG, PNG, GIF allowed.</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Video</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto">
            <?php include('includes/AdminFooter.php'); ?>
        </footer>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
    <script>
        function previewImage(input) {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = '';

            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                    alert('Invalid file type. Only JPG, PNG and GIF are allowed.');
                    input.value = '';
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 5MB.');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'image-preview';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>