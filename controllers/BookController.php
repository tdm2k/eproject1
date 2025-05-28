<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/BookModel.php';
require_once __DIR__ . '/../entities/Book.php';

class BookController {
    private $model;
    private $uploadDir = '../assets/books/';

    public function __construct() {
        $this->model = new BookModel();
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    private function handleImageUpload($file): ?string {
        if (!isset($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $this->uploadDir . $fileName;

        // Check if file is an actual image
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            return null;
        }

        // Check file size (5MB max)
        if ($file['size'] > 5000000) {
            return null;
        }

        // Allow certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowedTypes)) {
            return null;
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'assets/books/' . $fileName;
        }

        return null;
    }

    public function index() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 5; // Number of books per page
            $result = $this->model->getPaginatedBooks($page, $perPage);
            return ['status' => 'success', 'data' => $result];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function show($id) {
        try {
            if (!$id) {
                return ['status' => 'error', 'message' => 'Invalid book ID'];
            }
            $book = $this->model->getBookById($id);
            if ($book) {
                return ['status' => 'success', 'data' => $book];
            }
            return ['status' => 'error', 'message' => 'Book not found'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function add($data) {
        try {
            if (empty($data['title'])) {
                return ['status' => 'error', 'message' => 'Book title cannot be empty'];
            }

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
                if ($imagePath) {
                    $data['image_url'] = $imagePath;
                }
            }

            $bookId = $this->model->addBook($data);
            if ($bookId) {
                return ['status' => 'success', 'message' => 'Book added successfully', 'data' => $bookId];
            }
            return ['status' => 'error', 'message' => 'Failed to add book'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function update($id, $data) {
        try {
            if (!$id) {
                return ['status' => 'error', 'message' => 'Invalid book ID'];
            }
            if (empty($data['title'])) {
                return ['status' => 'error', 'message' => 'Book title cannot be empty'];
            }

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
                if ($imagePath) {
                    $data['image_url'] = $imagePath;
                }
            }

            $success = $this->model->updateBook($id, $data);
            if ($success) {
                return ['status' => 'success', 'message' => 'Book updated successfully'];
            }
            return ['status' => 'error', 'message' => 'Failed to update book'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function delete($id) {
        try {
            if (!$id) {
                return ['status' => 'error', 'message' => 'Invalid book ID'];
            }

            $success = $this->model->deleteBook($id);
            if ($success) {
                return ['status' => 'success', 'message' => 'Book deleted successfully'];
            }
            return ['status' => 'error', 'message' => 'Failed to delete book'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getBooksByCategory($categoryId) {
        try {
            if (!$categoryId) {
                return ['status' => 'error', 'message' => 'Invalid category ID'];
            }
            $books = $this->model->getBooksByCategory($categoryId);
            return ['status' => 'success', 'data' => $books];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getAllCategories() {
        try {
            $categories = $this->model->getAllCategories();
            return ['status' => 'success', 'data' => $categories];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? $_POST['action'] ?? null;

        if (!$action) {
            header('Location: ../admin/AdminBook.php?error=invalid-action');
            exit;
        }

        switch ($action) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    header('Location: ../admin/AdminBook.php?error=invalid-request-method');
                    exit;
                }
                $result = $this->add($_POST);
                if ($result['status'] === 'success') {
                    header('Location: ../admin/AdminBook.php?success=book-added');
                } else {
                    header('Location: ../admin/AdminBook.php?error=failed-to-add');
                }
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    header('Location: ../admin/AdminBook.php?error=invalid-request-method');
                    exit;
                }
                $result = $this->update($_POST['id'], $_POST);
                if ($result['status'] === 'success') {
                    header('Location: ../admin/AdminBook.php?success=book-updated');
                } else {
                    header('Location: ../admin/AdminBook.php?error=failed-to-update');
                }
                break;

            case 'delete':
                if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                    header('Location: ../admin/AdminBook.php?error=invalid-request-method');
                    exit;
                }
                $result = $this->delete($_GET['id']);
                if ($result['status'] === 'success') {
                    header('Location: ../admin/AdminBook.php?success=book-deleted');
                } else {
                    header('Location: ../admin/AdminBook.php?error=failed-to-delete');
                }
                break;

            default:
                header('Location: ../admin/AdminBook.php?error=invalid-action');
                exit;
        }
        exit;
    }
}

// Handle the request if this file is accessed directly
if (basename($_SERVER['PHP_SELF']) === 'BookController.php') {
    $controller = new BookController();
    $controller->handleRequest();
}