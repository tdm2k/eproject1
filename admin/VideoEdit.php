<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/VideoController.php';

$controller = new VideoController();
$video = null;

$errorMessages = [
    'invalid-action' => 'Invalid action specified.',
    'invalid-request-method' => 'Invalid request method.',
    'empty-video-title' => 'Video title cannot be empty.',
    'invalid-video-id' => 'Invalid video ID.',
    'video-not-found' => 'Video not found.',
    'invalid-file-type' => 'Invalid file type. Only JPG, PNG and GIF are allowed.',
    'file-too-large' => 'File is too large. Maximum size is 5MB.',
    'upload-failed' => 'Failed to upload file.',
    'failed-to-update' => 'Failed to update video.'
];

$successMessages = [
    'video-updated' => 'Video updated successfully!'
];

// Get video data for editing
if (isset($_GET['id'])) {
    $response = $controller->show((int)$_GET['id']);
    if ($response['status'] === 'success') {
        $video = $response['data'];
    } else {
        header('Location: AdminVideo.php?error=video-not-found');
        exit;
    }
} else {
    header('Location: AdminVideo.php?error=invalid-video-id');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Edit Video</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <main class="flex-grow-1 p-4">
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Edit Video</h2>
                    <a href="AdminVideo.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Videos
                    </a>
                </div>

                <?php if (isset($_GET['error']) && isset($errorMessages[$_GET['error']])): ?>
                    <div class="alert alert-danger"><?= $errorMessages[$_GET['error']] ?></div>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && isset($successMessages[$_GET['success']])): ?>
                    <div class="alert alert-success"><?= $successMessages[$_GET['success']] ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form action="../controllers/VideoController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $video->getId() ?>">

                            <div class="mb-3">
                                <label for="title" class="form-label">Video Title *</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="<?= htmlspecialchars($video->getTitle()) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label">Video URL *</label>
                                <input type="text" id="url" name="url" class="form-control"
                                    value="<?= htmlspecialchars($video->getUrl()) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*" onchange="previewImage(this)">
                                <?php if ($video->getThumbnailUrl()): ?>
                                    <img src="../<?= htmlspecialchars($video->getThumbnailUrl()) ?>" alt="Current Thumbnail" class="image-preview" id="imagePreview">
                                <?php else: ?>
                                    <img src="#" alt="Thumbnail Preview" class="image-preview" id="imagePreview" style="display:none;">
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Video Description</label>
                                <textarea id="description" name="description" rows="4" class="form-control"><?= htmlspecialchars($video->getDescription()) ?></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update Video</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-auto">
            <?php include '../admin/includes/AdminFooter.php'; ?>
        </footer>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>