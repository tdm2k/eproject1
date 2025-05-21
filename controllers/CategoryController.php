<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/CategoryModel.php';
require_once '../entities/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        try {
            $categories = $this->categoryModel->getAllCategories();
            return [
                'status' => 'success',
                'data' => $categories
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function show($id) {
        try {
            $category = $this->categoryModel->getCategoryById($id);
            if ($category) {
                return [
                    'status' => 'success',
                    'data' => $category
                ];
            }
            return [
                'status' => 'error',
                'message' => 'Category not found'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function add($name) {
        try {
            if (empty($name)) {
                return [
                    'status' => 'error',
                    'message' => 'Category name is required'
                ];
            }
            $this->categoryModel->addCategory($name);
            return [
                'status' => 'success',
                'message' => 'Category added successfully'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function update($id, $name) {
        try {
            if (empty($name)) {
                return [
                    'status' => 'error',
                    'message' => 'Category name is required'
                ];
            }
            $this->categoryModel->updateCategory($id, $name);
            return [
                'status' => 'success',
                'message' => 'Category updated successfully'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($id) {
        try {
            $this->categoryModel->deleteCategory($id);
            return [
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}

// Handle direct requests to the controller
if (isset($_GET['action'])) {
    $controller = new CategoryController();
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            $name = $_POST['name'] ?? '';
            $result = $controller->add($name);
            header('Location: ../admin/AdminCategory.php?action=categoryList&' . ($result['status'] === 'success' ? 'status=category-added' : 'error=' . urlencode($result['message'])));
            break;
        case 'update':
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $result = $controller->update($id, $name);
            header('Location: ../admin/AdminCategory.php?action=categoryList&' . ($result['status'] === 'success' ? 'status=category-updated' : 'error=' . urlencode($result['message'])));
            break;
        case 'delete':
            $id = $_GET['id'] ?? '';
            $result = $controller->delete($id);
            header('Location: ../admin/AdminCategory.php?action=categoryList&' . ($result['status'] === 'success' ? 'status=category-deleted' : 'error=' . urlencode($result['message'])));
            break;
        default:
            header('Location: ../admin/AdminCategory.php?error=invalid-action');
    }
    exit;
}