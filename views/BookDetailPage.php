<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../controllers/BookController.php';

// Lấy ID từ URL và gọi controller
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$controller = new BookController();

// Giả lập phương thức show() nếu chưa có trong BookController
function getBookDetails(BookController $controller, ?int $id): array
{
    if (!$id) {
        return ['status' => 'error', 'message' => 'Invalid book ID'];
    }
    $model = new BookModel();
    try {
        $book = $model->getBookById($id);
        if ($book) {
            return ['status' => 'success', 'data' => $book];
        } else {
            return ['status' => 'error', 'message' => 'Book not found'];
        }
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => 'Failed to fetch book: ' . $e->getMessage()];
    }
}

$response = getBookDetails($controller, $id);
$book = $response['status'] === 'success' && $response['data'] ? $response['data'] : null;
$error_message = $response['status'] === 'error' ? $response['message'] : null;

// Lấy thông báo từ query string (nếu có)
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Book Details</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            padding-top: 76px;
        }

        .bg-book {
            position: relative;
            background-image: url('../<?php echo $book->getImageUrl(); ?>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            min-height: 50vh;
            width: 100%;
            display: flex;
            align-items: center;
            color: white;
            overflow: hidden;
            z-index: 0;
        }

        .bg-book::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .bg-book>* {
            position: relative;
            z-index: 2;
        }

        .detail-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section {
            padding: 60px 0;
        }

        .detail-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .book-cover {
            max-width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .book-cover:hover {
            transform: scale(1.02);
        }
    </style>
</head>

<body>
    <?php include '../includes/Header.php'; ?>

    <!-- Section: Book Header -->
    <section class="bg-book">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4"><?php echo html_entity_decode(htmlspecialchars($book ? $book->getTitle() : 'Book Details')); ?></h1>
                    <p class="fs-5">Discover more about this fascinating book</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Book Details -->
    <section class="section">
        <div class="container">
            <?php if ($message): ?>
                <div class="alert <?php echo strpos($status, 'failed') === false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                    <?php echo html_entity_decode(htmlspecialchars($message)); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo html_entity_decode(htmlspecialchars($error_message)); ?>
                </div>
            <?php elseif ($book): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 text-center mb-4">
                            <?php if ($book->getImageUrl()): ?>
                                <img src="../<?php echo htmlspecialchars($book->getImageUrl()); ?>"
                                    alt="<?php echo html_entity_decode(htmlspecialchars($book->getTitle())); ?>"
                                    class="book-cover img-fluid rounded">
                            <?php else: ?>
                                <img src="../assets/images/no-image.png" alt="No image" class="book-cover img-fluid rounded">
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-8">
                            <div class="detail-section">
                                <h2 class="display-5 fw-bold mb-4"><?php echo htmlspecialchars($book->getTitle()); ?></h2>
                                
                                <div class="detail-item">
                                    <h5>Author</h5>
                                    <p><?php echo htmlspecialchars($book->getAuthor()); ?></p>
                                </div>

                                <div class="detail-item">
                                    <h5>Publisher</h5>
                                    <p><?php echo htmlspecialchars($book->getPublisher()); ?></p>
                                </div>

                                <div class="detail-item">
                                    <h5>Published Year</h5>
                                    <p><?php echo htmlspecialchars($book->getPublishYear()); ?></p>
                                </div>

                                <div class="detail-item">
                                    <h5>Categories</h5>
                                    <p>
                                        <?php
                                        $categories = $book->getCategories();
                                        if (!empty($categories)) {
                                            echo htmlspecialchars(implode(', ', array_column($categories, 'name')));
                                        } else {
                                            echo 'No categories specified';
                                        }
                                        ?>
                                    </p>
                                </div>

                                <?php if ($book->getBuyLink()): ?>
                                    <div class="mt-4">
                                        <a href="<?php echo htmlspecialchars($book->getBuyLink()); ?>" 
                                           class="btn btn-primary" 
                                           target="_blank">
                                            <i class="bi bi-cart"></i> Buy This Book
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="detail-section">
                                <h3 class="mb-4">Description</h3>
                                <p><?php echo nl2br(html_entity_decode($book->getDescription())); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <p class="text-muted">Book not found.</p>
                    <a href="BookPage.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Back to Books
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include '../includes/Footer.php'; ?>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html> 