<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../entities/Category.php';

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function index() {
        try {
            $categories = $this->model->getAllCategories();
            return ['status' => 'success', 'data' => $categories];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function handleAddCategory()
    {
        $name = $_POST['name'] ?? null;

        if ($name) {
            $this->model->addCategory($name);
            header('Location: ../admin/AdminCategory.php?action=categoryList&status=category-added');
            exit;
        } else {
            header('Location: ../admin/AdminCategory.php?action=categoryList&error=empty-category-name');
            exit;
        }
    }

    public function handleDeleteCategory()
    {
        $categoryId = $_GET['id'] ?? null;

        if ($categoryId) {
            $this->model->deleteCategory($categoryId);
            header('Location: ../admin/AdminCategory.php?action=categoryList&status=category-deleted');
            exit;
        } else {
            header('Location: ../admin/AdminCategory.php?action=categoryList&error=invalid-category-id');
            exit;
        }
    }

    public function handleUpdateCategory()
    {
        $categoryId = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? null;

        if ($categoryId && $name) {
            $this->model->updateCategory($categoryId, $name);
            header('Location: ../admin/AdminCategory.php?action=categoryList&status=category-updated');
            exit;
        } else {
            header('Location: ../admin/AdminCategory.php?action=categoryList&error=empty-category-name');
            exit;
        }
    }
}
