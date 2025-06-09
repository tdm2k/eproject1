<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../controllers/BookController.php';

$bookController = new BookController();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$response = $bookController->index();
$paginationData = $response['status'] === 'success' ? $response['data'] : null;
$books = $paginationData ? $paginationData['books'] : [];
$error_message = $response['status'] === 'error' ? $response['message'] : null;

$error = $_GET['error'] ?? null;
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
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
$successMessages = [
    'book-added' => 'Book added successfully!',
    'book-updated' => 'Book updated successfully!',
    'book-deleted' => 'Book deleted successfully!'
];
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
            margin-left: 280px;
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

        <main class="flex-grow-1 p-4">

            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-4">Books Management</h1>
                    <div>
                        <a href="BookForm.php" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Add New Book
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