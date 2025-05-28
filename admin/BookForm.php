<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/BookController.php';

// Initialize controllers
$bookController = new BookController();

// Initialize variables
$book = null;
$categories = [];
$error = null;
$success = null;
$errorMessages = [
    'invalid-action' => 'Invalid action specified.',
    'invalid-request-method' => 'Invalid request method.',
    'invalid-book-id' => 'Invalid book ID.',
    'book-not-found' => 'Book not found.',
    'failed-to-add' => 'Failed to add book.',
    'failed-to-update' => 'Failed to update book.',
    'failed-to-delete' => 'Failed to delete book.',
    'error-loading-categories' => 'Error loading categories.'
];
$successMessages = [
    'book-added' => 'Book added successfully!',
    'book-updated' => 'Book updated successfully!',
    'book-deleted' => 'Book deleted successfully!'
];
// Fetch all categories
try {
    $categoriesResponse = $bookController->getAllCategories();
    if ($categoriesResponse['status'] === 'success') {
        $categories = $categoriesResponse['data'];
    }
} catch (Exception $e) {
    $error = "Error loading categories: " . $e->getMessage();
}

// Fetch book data if editing
if (isset($_GET['id'])) {
    try {
        $response = $bookController->show($_GET['id']);
        if ($response['status'] === 'success') {
            $book = $response['data'];
        } else {
            $error = $response['message'];
        }
    } catch (Exception $e) {
        $error = "Error loading book: " . $e->getMessage();
    }
}

// Page title
$pageTitle = $book ? 'Edit Book' : 'Add New Book';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin - <?php echo $pageTitle; ?></title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <style>
        .main-page-content {
            margin-left: 250px;
            padding: 20px;
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
                    <h2><?php echo $pageTitle; ?></h2>
                    <a href="AdminBook.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Books
                    </a>
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
                <form action="../controllers/BookController.php" method="POST" enctype="multipart/form-data">
                    <?php if ($book): ?>
                        <input type="hidden" name="id" value="<?php echo $book->getId(); ?>">
                    <?php endif; ?>
                    <input type="hidden" name="action" value="<?php echo $book ? 'update' : 'add'; ?>">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required
                            value="<?php echo $book ? htmlspecialchars($book->getTitle()) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Author *</label>
                        <input type="text" class="form-control" id="author" name="author" required
                            value="<?php echo $book ? htmlspecialchars($book->getAuthor()) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="publisher" class="form-label">Publisher</label>
                        <input type="text" class="form-control" id="publisher" name="publisher"
                            value="<?php echo $book ? htmlspecialchars($book->getPublisher()) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="publish_year" class="form-label">Publish Year</label>
                        <input type="number" class="form-control" id="publish_year" name="publish_year"
                            value="<?php echo $book ? htmlspecialchars($book->getPublishYear()) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo $book ? htmlspecialchars($book->getDescription()) : ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="buy_link" class="form-label">Buy Link</label>
                        <input type="url" class="form-control" id="buy_link" name="buy_link"
                            value="<?php echo $book ? htmlspecialchars($book->getBuyLink()) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="categories" class="form-label">Categories</label>
                        <select class="selectpicker form-control" id="categories" name="categories[]" multiple data-live-search="true" data-width="100%" title="Select categories">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                        <?php echo ($book && in_array($category['id'], array_column($book->getCategories(), 'id'))) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No categories available</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Book Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        <div class="mt-2" id="imagePreviewContainer" style="display: <?php echo ($book && $book->getImageUrl()) ? 'block' : 'none'; ?>">
                            <img id="imagePreview"
                                src="<?php echo ($book && $book->getImageUrl()) ? '../' . htmlspecialchars($book->getImageUrl()) : ''; ?>"
                                alt="Image Preview"
                                class="img-thumbnail"
                                style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $book ? 'Update Book' : 'Add Book'; ?>
                        </button>
                    </div>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker({
                noneSelectedText: 'Select categories',
                noneResultsText: 'No categories found',
                selectAllText: 'Select All',
                deselectAllText: 'Deselect All',
                liveSearchPlaceholder: 'Search categories...'
            });
        });

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