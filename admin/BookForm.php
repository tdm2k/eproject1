<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/BookController.php';
require_once '../controllers/CategoryController.php';

// Initialize controllers
$bookController = new BookController();
$categoryController = new CategoryController();

// Initialize variables
$book = null;
$categories = [];
$error = null;
$success = null;

// Fetch categories
try {
    $categoryResponse = $categoryController->index();
    if ($categoryResponse['status'] === 'success') {
        $categories = $categoryResponse['data'];
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

        <main class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><?php echo $pageTitle; ?></h2>
                        <a href="AdminBook.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Books
                        </a>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
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
                                    <select class="form-select" id="categories" name="categories[]" multiple>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category->getId(); ?>"
                                                <?php echo ($book && in_array($category->getId(), array_column($book->getCategories(), 'id'))) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category->getName()); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                               
                                <div class="mb-3">
                                    <label for="image" class="form-label">Book Cover Image</label>
                                    <?php if ($book && $book->getImageUrl()): ?>
                                        <div class="mb-2">
                                            <img src="../<?php echo htmlspecialchars($book->getImageUrl()); ?>"
                                                alt="Current book cover" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo $book ? 'Update Book' : 'Add Book'; ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <div>
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html> 