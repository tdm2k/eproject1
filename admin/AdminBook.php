<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/BookController.php';

$bookController = new BookController();


$response = $bookController->index();
$books = $response['status'] === 'success' ? $response['data'] : [];
$error_message = $response['status'] === 'error' ? $response['message'] : null;

$error = $_GET['error'] ?? null;
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin - Books</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <style>
        .main-page-content {
            margin-left: 250px;
            padding: 20px;
        }

        .book-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
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
                        <h2>Manage Books</h2>
                        <a href="BookForm.php" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Add New Book
                        </a>
                    </div>

                    <?php
                    $errorMessages = [
                        'invalid-action' => 'Invalid action specified.',
                        'invalid-request-method' => 'Invalid request method.',
                        'empty-book-title' => 'Book title cannot be empty.',
                        'invalid-book-id' => 'Invalid book ID.',
                        'book-not-found' => 'Book not found.',
                        'failed-to-add' => 'Failed to add book.',
                        'failed-to-update' => 'Failed to update book.',
                        'failed-to-delete' => 'Failed to delete book.',
                        'error-loading-categories' => 'Error loading categories.'
                    ];

                    if (isset($_GET['error']) && isset($errorMessages[$_GET['error']])): ?>
                        <div class="alert alert-danger error-notification show" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <?= $errorMessages[$_GET['error']] ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $successMessages = [
                        'book-added' => 'Book added successfully!',
                        'book-updated' => 'Book updated successfully!',
                        'book-deleted' => 'Book deleted successfully!'
                    ];

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

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Publisher</th>
                                            <th>Year</th>
                                            <th>Categories</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($books)): ?>
                                            <?php foreach ($books as $book): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($book->getId()); ?></td>
                                                    <td>
                                                        <?php if ($book->getImageUrl()): ?>
                                                            <img src="../<?php echo htmlspecialchars($book->getImageUrl()); ?>"
                                                                alt="<?php echo htmlspecialchars($book->getTitle()); ?>"
                                                                class="book-image rounded">
                                                        <?php else: ?>
                                                            <p class="text-muted">No image</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo html_entity_decode(htmlspecialchars($book->getTitle())); ?></td>
                                                    <td><?php echo htmlspecialchars($book->getAuthor()); ?></td>
                                                    <td><?php echo htmlspecialchars($book->getPublisher()); ?></td>
                                                    <td><?php echo htmlspecialchars($book->getPublishYear()); ?></td>
                                                    <td>
                                                        <?php
                                                        $categories = $book->getCategories();
                                                        if (!empty($categories)) {
                                                            echo htmlspecialchars(implode(', ', array_column($categories, 'name')));
                                                        } else {
                                                            echo 'No categories';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="BookEdit.php?id=<?php echo $book->getId(); ?>"
                                                                class="btn btn-primary btn-sm me-2">
                                                                <i class="bi bi-pencil"></i> Edit
                                                            </a>
                                                            <a href="../controllers/BookController.php?action=delete&id=<?php echo $book->getId(); ?>"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this book?')">
                                                                <i class="bi bi-trash"></i> Delete
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No books found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
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
    <script src="../assets/js/simple-notification.js"></script>
</body>

</html>