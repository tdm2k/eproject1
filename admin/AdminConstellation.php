<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
        exit;
    }
}

require_once '../controllers/ConstellationController.php';
require_once '../models/ConstellationModel.php';

$model = new ConstellationModel();
$controller = new ConstellationController($model);
$action = $_GET['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest($action, $_POST);
    exit;
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $controller->handleRequest('delete', ['id' => $_GET['id']]);
    exit;
}

$constellations = $controller->getAllConstellations();
$constellation = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $constellation = $controller->getConstellationById($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Constellation Management</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>.main-page-content { margin-left: 280px; }</style>
</head>
<body>
<div class="main-page-content d-flex flex-column min-vh-100">
    <?php include '../admin/includes/AdminSidebar.php'; ?>

    <main class="flex-grow-1 p-4">
        <h2>Manage Constellations</h2>

        <?php if ($action === 'add' || $action === 'edit'): ?>
            <a href="AdminConstellation.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Back to List</a>
            <form method="POST">
                <?php if ($action === 'edit'): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($constellation['id']) ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Constellation Name</label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($constellation['name'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Image (URL)</label>
                    <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($constellation['image'] ?? '') ?>">
                    <?php if (!empty($constellation['image'])): ?>
                        <img src="<?= htmlspecialchars($constellation['image']) ?>" class="mt-2" width="150">
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($constellation['description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notable Stars</label>
                    <input type="text" name="notable_stars" class="form-control" value="<?= htmlspecialchars($constellation['notable_stars'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select id="category_id" name="category_id">
                        <option value="2">Constellation</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Coordinates (e.g., RA: 14h 15m, Dec: -60°)</label>
                    <input type="text" name="position" class="form-control" value="<?= htmlspecialchars($constellation['position'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Legend</label>
                    <textarea name="legend" class="form-control" rows="4"><?= htmlspecialchars($constellation['legend'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> <?= $action === 'edit' ? 'Update' : 'Add New' ?>
                </button>
            </form>
        <?php else: ?>
            <a href="AdminConstellation.php?action=add" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Add Constellation</a>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Notable Stars</th>
                    <th>Category</th>
                    <th>Coordinates</th>
                    <th>Legend</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($constellations as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td>
                            <?php if (!empty($c['image'])): ?>
                                <img src="<?= htmlspecialchars($c['image']) ?>" width="60">
                            <?php endif; ?>
                        </td>
                        <td><?= nl2br(htmlspecialchars($c['description'])) ?></td>
                        <td><?= htmlspecialchars($c['notable_stars']) ?></td>
                        <td><?= htmlspecialchars($c['category_id']) ?></td>
                        <td><?= htmlspecialchars($c['position']) ?></td>
                        <td><?= nl2br(htmlspecialchars($c['legend'])) ?></td>
                        <td>
                            <a href="?action=edit&id=<?= $c['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                            <a href="?action=delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"><i class="bi bi-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer class="mt-auto">
        <?php include('../admin/includes/AdminFooter.php'); ?>
    </footer>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
