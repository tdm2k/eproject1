<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/ObservatoryController.php';

$controller = new ObservatoryController();
$observatory = null;

$errorMessages = [
    'invalid-action' => 'Invalid action specified.',
    'invalid-request-method' => 'Invalid request method.',
    'empty-observatory-name' => 'Observatory name cannot be empty.',
    'invalid-observatory-id' => 'Invalid observatory ID.',
    'observatory-not-found' => 'Observatory not found.',
    'invalid-file-type' => 'Invalid file type. Only JPG, PNG and GIF are allowed.',
    'file-too-large' => 'File is too large. Maximum size is 5MB.',
    'upload-failed' => 'Failed to upload file.',
    'failed-to-update' => 'Failed to update observatory.'
];

$successMessages = [
    'observatory-updated' => 'Observatory updated successfully!'
];

// Get observatory data for editing
if (isset($_GET['id'])) {
    $response = $controller->show((int)$_GET['id']);
    if ($response['status'] === 'success') {
        $observatory = $response['data'];
    } else {
        header('Location: AdminObservatory.php?error=observatory-not-found');
        exit;
    }
} else {
    header('Location: AdminObservatory.php?error=invalid-observatory-id');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin - Edit Observatory</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <style>
        .main-page-content {
            margin-left: 250px;
            padding: 20px;
        }
        #imagePreview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 4px;
            margin-top: 10px;
        }
        .existing-image {
            position: relative;
            display: inline-block;
            margin: 5px;
        }
        .existing-image img {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }
        .delete-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <main class="flex-grow-1 p-4">
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Edit Observatory</h2>
                    <a href="AdminObservatory.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Observatories
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
                        <form action="../controllers/ObservatoryController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $observatory->getId() ?>">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($observatory->getName()) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location *</label>
                                <input type="text" class="form-control" id="location" name="location" 
                                       value="<?= nl2br(html_entity_decode($observatory->getLocation())) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Observatory Image</label>
                                <input type="file" class="form-control" id="image" name="image" 
                                       accept="image/*" 
                                       onchange="previewImage(this)">
                                <div class="mt-2" id="imagePreviewContainer" 
                                     style="display: <?= $observatory->getImageUrl() ? 'block' : 'none' ?>">
                                    <img id="imagePreview"
                                         src="<?= $observatory->getImageUrl() ? '../' . htmlspecialchars($observatory->getImageUrl()) : '' ?>"
                                         alt="Image Preview"
                                         class="img-thumbnail">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="4"><?= htmlspecialchars($observatory->getDescription()) ?></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Observatory</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto">
            <?php include '../admin/includes/AdminFooter.php'; ?>
        </footer>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('imagePreviewContainer');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
            }
        }
    </script>
</body>
</html> 