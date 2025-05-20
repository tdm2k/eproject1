<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once '../controllers/BookController.php';

$bookController = new BookController();
$book = null;
$error = null;

if (!isset($_GET['id'])) {
    header('Location: AdminBook.php?error=invalid-book-id');
    exit;
}

$response = $bookController->show($_GET['id']);
if ($response['status'] === 'success') {
    $book = $response['data'];
} else {
    header('Location: AdminBook.php?error=' . urlencode($response['message']));
    exit;
}

// Redirect to the form with the book ID
header('Location: BookForm.php?id=' . $book->getId());
exit; 