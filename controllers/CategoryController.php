<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../models/CategoryModel.php';
require_once '../entities/Category.php';

$categoryModel = new CategoryModel();

$action = $_GET['action'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($action) {
        case 'add':
            handleAddCategory($categoryModel);
            break;
        case 'delete':
            handleDeleteCategory($categoryModel);
            break;
        case 'update':
            handleUpdateCategory($categoryModel);
            break;
        default:
            header('Location: ../admin/AdminCategory.php?error=invalid-action');
            exit;
    }
} else {
    header('Location: ../admin/AdminCategory.php?error=invalid-request-method');
    exit;
}

// --- Hàm xử lý Add Category ---
function handleAddCategory(CategoryModel $categoryModel)
{
    $name = $_POST['name'] ?? null;

    if ($name) {
        $categoryModel->addCategory($name);
        header('Location: ../admin/AdminCategory.php?action=categoryList&status=category-added');
        exit;
    } else {
        header('Location: ../admin/AdminCategory.php?action=categoryList&error=empty-category-name');
        exit;
    }
}

// --- Hàm xử lý Delete Category ---
function handleDeleteCategory(CategoryModel $categoryModel)
{
    $categoryId = $_GET['id'] ?? null;

    if ($categoryId) {
        $categoryModel->deleteCategory($categoryId);
        header('Location: ../admin/AdminCategory.php?action=categoryList&status=category-deleted');
        exit;
    } else {
        header('Location: ../admin/AdminCategory.php?action=categoryList&error=invalid-category-id');
        exit;
    }
}

// --- Hàm xử lý Update Category ---
function handleUpdateCategory(CategoryModel $categoryModel)
{
    $categoryId = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;

    if ($categoryId && $name) {
        $categoryModel->updateCategory($categoryId, $name);
        header('Location: ../admin/AdminCategory.php?action=categoryList&status=category-updated');
        exit;
    } else {
        header('Location: ../admin/AdminCategory.php?action=categoryList&error=empty-category-name');
        exit;
    }
}
