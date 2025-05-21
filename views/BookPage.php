<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../controllers/BookController.php';

$controller = new BookController();

// Lấy danh sách danh mục
$categoriesResponse = $controller->getAllCategories();
$categories = $categoriesResponse['status'] === 'success' ? $categoriesResponse['data'] : [];

// Lấy tất cả sách
$response = $controller->index();
$allBooks = $response['status'] === 'success' ? $response['data'] : [];
$error_message = $response['status'] === 'error' ? $response['message'] : null;

// Lấy thông báo từ query string (nếu có)
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;

// Phân loại sách theo danh mục
$booksByCategory = [];
foreach ($allBooks as $book) {
    foreach ($book->getCategories() as $category) {
        $categoryName = $category['name'];
        if (!isset($booksByCategory[$categoryName])) {
            $booksByCategory[$categoryName] = [];
        }
        $booksByCategory[$categoryName][] = $book;
    }
}

// Chia danh mục thành 2 cột
$categoriesPerColumn = ceil(count($categories) / 2);
$firstColumnCategories = array_slice($categories, 0, $categoriesPerColumn);
$secondColumnCategories = array_slice($categories, $categoriesPerColumn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Books</title>
    <!-- Bootstrap -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            padding-top: 76px;
        }

        .book-card {
            transition: transform 0.3s ease;
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .book-cover {
            height: 300px;
            object-fit: cover;
        }

        .category-badge {
            font-size: 0.8rem;
            margin-right: 0.3rem;
            margin-bottom: 0.3rem;
        }

        .category-section {
            margin-bottom: 4rem;
            scroll-margin-top: 100px;
        }

        .category-title {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #dee2e6;
        }

        .category-link {
            transition: all 0.3s ease;
        }

        .category-link:hover {
            color: #0d6efd !important;
            padding-left: 10px;
        }

        .category-link span {
            transition: transform 0.3s ease;
        }

        .category-link:hover span {
            transform: translateY(3px);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div>
        <?php include('../includes/Header.php'); ?>
    </div>

    <!-- Page Content -->
    <div class="container" style="margin-top: 6%">
        <p>Book Page</p>
    </div>

    <!-- Footer -->
    <div>
        <?php include('../includes/Footer.php'); ?>
    </div>

    <!-- Bootstrap -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>