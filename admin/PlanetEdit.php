<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/PlanetController.php';
require_once '../entities/Category.php';
require_once '../models/CategoryModel.php';

$controller = new PlanetController();
$planet = null;

// Lấy thông tin hành tinh để edit
if (isset($_GET['id'])) {
    $response = $controller->show((int)$_GET['id']);
    if ($response['status'] === 'success') {
        $planet = $response['data'];
    } else {
        header('Location: AdminPlanet.php?error=planet-not-found');
        exit;
    }
} else {
    header('Location: AdminPlanet.php?error=invalid-planet-id');
    exit;
}

try {
    $categoryModel = new CategoryModel();
    $categories = $categoryModel->getAllCategories();
} catch (Exception $e) {
    $categories = [];
    $error = "Failed to load categories: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin - Edit Planet</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <style>
        .main-page-content {
            margin-left: 280px;
        }
    </style>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>
        <main class="flex-grow-1 p-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Edit Planet</h2>
                    <a href="AdminPlanet.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Planets
                    </a>
                </div>

                <?php
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

                if (isset($_GET['error']) && isset($errorMessages[$_GET['error']])): ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?= $errorMessages[$_GET['error']] ?>
                    </div>
                <?php endif; ?>

                <?php
                $successMessages = [
                    'planet-added' => 'Planet added successfully!',
                    'planet-updated' => 'Planet updated successfully!',
                    'planet-deleted' => 'Planet deleted successfully!',
                    'planet-restored' => 'Planet restored successfully!',
                    'planet-permanently-deleted' => 'Planet permanently deleted!'
                ];

                if (isset($_GET['success']) && isset($successMessages[$_GET['success']])): ?>
                    <div class="alert alert-success success-notification show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= $successMessages[$_GET['success']] ?>
                    </div>
                <?php endif; ?>

                <form action="../controllers/PlanetController.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $planet->getId(); ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Planet Name</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            value="<?php echo htmlspecialchars($planet->getName()); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Planet Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        <div class="mt-2" id="imagePreviewContainer" style="display: <?php echo $planet->getImage() ? 'block' : 'none'; ?>">
                            <img id="imagePreview"
                                src="<?php echo $planet->getImage() ? '../' . htmlspecialchars($planet->getImage()) : ''; ?>"
                                alt="Image Preview"
                                class="img-thumbnail"
                                style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($planet->getDescription()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="potential_for_life" class="form-label">Potential for Life</label>
                        <textarea class="form-control" id="potential_for_life" name="potential_for_life" rows="2"><?php echo htmlspecialchars($planet->getPotentialForLife()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="orbit_and_rotation" class="form-label">Orbit and Rotation</label>
                        <textarea class="form-control" id="orbit_and_rotation" name="orbit_and_rotation" rows="2"><?php echo htmlspecialchars($planet->getOrbitAndRotation()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="rings" class="form-label">Has Rings</label>
                        <select class="form-control" id="rings" name="rings">
                            <option value="0" <?php echo !$planet->getRings() ? 'selected' : ''; ?>>No</option>
                            <option value="1" <?php echo $planet->getRings() ? 'selected' : ''; ?>>Yes</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="structure" class="form-label">Structure</label>
                        <textarea class="form-control" id="structure" name="structure" rows="2"><?php echo htmlspecialchars($planet->getStructure()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="atmosphere" class="form-label">Atmosphere</label>
                        <textarea class="form-control" id="atmosphere" name="atmosphere" rows="2"><?php echo htmlspecialchars($planet->getAtmosphere()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="name_sake" class="form-label">Name Sake</label>
                        <input type="text" class="form-control" id="name_sake" name="name_sake"
                            value="<?php echo htmlspecialchars($planet->getNameSake()); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="size_and_distance" class="form-label">Size and Distance</label>
                        <textarea class="form-control" id="size_and_distance" name="size_and_distance" rows="2"><?php echo htmlspecialchars($planet->getSizeAndDistance()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="moons" class="form-label">Moons</label>
                        <input type="text" class="form-control" id="moons" name="moons"
                            value="<?php echo htmlspecialchars($planet->getMoons()); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="formation" class="form-label">Formation</label>
                        <textarea class="form-control" id="formation" name="formation" rows="2"><?php echo htmlspecialchars($planet->getFormation()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="surface" class="form-label">Surface</label>
                        <textarea class="form-control" id="surface" name="surface" rows="2"><?php echo htmlspecialchars($planet->getSurface()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="magnetosphere" class="form-label">Magnetosphere</label>
                        <textarea class="form-control" id="magnetosphere" name="magnetosphere" rows="2"><?php echo htmlspecialchars($planet->getMagnetosphere()); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category->getId()); ?>"
                                        <?php echo $planet->getCategoryId() == $category->getId() ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->getName()); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No categories available</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update Planet</button>
                    </div>
                </form>
            </div>
        </main>
        <footer class="mt-auto">
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </footer>
    </div>

    <!-- Bootstrap -->
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