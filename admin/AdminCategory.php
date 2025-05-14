<?php
require_once '../models/CategoryModel.php';
require_once '../entities/Category.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
    }
}
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();
sort($categories);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin</title>
    <!-- Bootstrap -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
    <!-- CSS -->
    <style>
        .main-page-content {
            margin-left: 280px;
        }

        .categories-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .action-column {
            text-align: right;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="main-page-content d-flex flex-column min-vh-100">
        <!-- Sidebar -->
        <?php include '../admin/includes/AdminSidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4">
            <div class="container mt-5">
                <div class="categories-header">
                    <h2 class="mb-0">Categories</h2>
                    <a class="btn btn-md btn-success add-category-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal">
                        <i class="bi bi-plus-circle-fill me-2"></i> Add
                    </a>
                </div>

                <!-- Success Notification -->
                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] === 'category-updated'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Category updated successfully!
                        </div>
                    <?php elseif ($_GET['status'] === 'category-added'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Category added successfully!
                        </div>
                    <?php elseif ($_GET['status'] === 'category-deleted'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Category deleted successfully!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Error Notification -->
                <?php if (isset($_GET['error'])):
                    $error = $_GET['error']; ?>
                    <div class="alert alert-danger error-notification show" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="action-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= $category->getId() ?></td>
                                <td><?= $category->getName() ?></td>
                                <td class="action-column">
                                    <a href="#" class="btn btn-sm btn-warning edit-category-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCategoryModal"
                                        data-category-id="<?= $category->getId() ?>"
                                        data-category-name="<?= $category->getName() ?>">
                                        <i class="bi bi-pencil-fill me-2"></i> Edit
                                    </a>
                                    <a href="../controllers/CategoryController.php?action=delete&id=<?= $category->getId() ?>" class="btn btn-sm btn-danger" onclick="return confirm('Do you really want to delete this category?');">
                                        <i class="bi bi-trash-fill me-2"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <div>
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </div>
    </div>

    <!-- Modal Add Category -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" action="../controllers/CategoryController.php?action=add" method="POST">
                        <div class="mb-3">
                            <label for="addCategoryModalName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="addCategoryModalName" name="name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="addCategoryForm">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Category -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" action="../controllers/CategoryController.php?action=update" method="POST">
                        <input type="hidden" name="id" id="editCategoryModalId">
                        <div class="mb-3">
                            <label for="editCategoryModalName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editCategoryModalName" name="name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="editCategoryForm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-category-btn').click(function() {
                var categoryId = $(this).data('category-id');
                var categoryName = $(this).data('category-name');
                $('#editCategoryModalId').val(categoryId);
                $('#editCategoryModalName').val(categoryName);
            });
        });
    </script>
</body>

</html>