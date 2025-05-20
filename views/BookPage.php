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
    <div class="container py-5">
        <?php if ($message): ?>
            <div class="alert <?php echo strpos($status, 'failed') === false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo html_entity_decode(htmlspecialchars($message)); ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo html_entity_decode(htmlspecialchars($error_message)); ?>
            </div>
        <?php endif; ?>

        <div class="row d-flex">
            <div class="col-lg-6">
                <h1 class="display-4 mb-4 fw-bold">Books</h1>
                <p class="lead mb-5">Discover our collection of space-related books</p>
            </div>
            <div class="col-lg-6">
                <div class="row" style="font-size: 14px;">
                    <div class="col-6 ">
                        <ul class="list-unstyled">
                            <?php foreach ($firstColumnCategories as $category): ?>
                                <li class="border-bottom py-2">
                                    <a href="#category-<?php echo strtolower(str_replace(' ', '-', $category['name'])); ?>" 
                                       class="category-link d-flex justify-content-between text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                        <span>&#x2193;</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <?php foreach ($secondColumnCategories as $category): ?>
                                <li class="border-bottom py-2">
                                    <a href="#category-<?php echo strtolower(str_replace(' ', '-', $category['name'])); ?>" 
                                       class="category-link d-flex justify-content-between text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                        <span>&#x2193;</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($booksByCategory)): ?>
            <div class="alert alert-info">
                No books found.
            </div>
        <?php else: ?>
            <?php foreach ($booksByCategory as $categoryName => $books): ?>
                <div id="category-<?php echo strtolower(str_replace(' ', '-', $categoryName)); ?>" class="category-section">
                    <h2 class="category-title"><?php echo htmlspecialchars($categoryName); ?></h2>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($books as $book): ?>
                            <div class="col">
                                <div class="card book-card h-100">
                                    <?php if ($book->getImageUrl()): ?>
                                        <img src="../<?php echo htmlspecialchars($book->getImageUrl()); ?>"
                                            class="card-img-top book-cover"
                                            alt="<?php echo htmlspecialchars($book->getTitle()); ?>">
                                    <?php else: ?>
                                        <img src="../assets/images/no-image.png"
                                            class="card-img-top book-cover"
                                            alt="No image">
                                    <?php endif; ?>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($book->getTitle()); ?></h5>
                                        <p class="card-text text-muted fw-bold">By: <strong style="color: red;"><?php echo htmlspecialchars($book->getAuthor()); ?></strong></p>
                                        
                                        <?php if (!empty($book->getCategories())): ?>
                                            <div class="mb-3">
                                                <?php foreach ($book->getCategories() as $category): ?>
                                                    <span class="badge bg-secondary category-badge">
                                                        <?php echo htmlspecialchars($category['name']); ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <p class="card-text">
                                            <?php
                                            $description = $book->getDescription();
                                            echo nl2br(strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description);
                                            ?>
                                        </p>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent border-top-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="BookDetailPage.php?id=<?php echo $book->getId(); ?>" class="btn btn-primary">
                                                Read More
                                            </a>
                                            <?php if ($book->getBuyLink()): ?>
                                                <a href="<?php echo htmlspecialchars($book->getBuyLink()); ?>" 
                                                   class="btn btn-outline-primary" 
                                                   target="_blank">
                                                    <i class="bi bi-cart"></i> Buy
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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