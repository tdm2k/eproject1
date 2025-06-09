<?php
require_once '../models/CometModel.php';
require_once '../entities/Comet.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../index.php');
    }
}

$cometModel = new CometModel();
$allComets = $cometModel->getAllComets();
sort($allComets);

// Cấu hình phân trang
$records_per_page = 8;
$total_records = count($allComets);
$total_pages = ceil($total_records / $records_per_page);

$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
}

$offset = ($current_page - 1) * $records_per_page;

$comets = array_slice($allComets, $offset, $records_per_page);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dot Com | Admin</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/simple-notification.css">
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
        <?php include '../admin/includes/AdminSidebar.php'; ?>
        <main class="flex-grow-1 p-4">
            <div class="container py-5">
                <div class="categories-header">
                    <h2 class="mb-0">Comets</h2>
                    <a class="btn btn-md btn-success add-category-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#addCometModal">
                        <i class="bi bi-plus-circle-fill me-2"></i> Add
                    </a>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <?php if ($_GET['success'] === 'comet-updated'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Comet updated successfully!
                        </div>
                    <?php elseif ($_GET['success'] === 'comet-added'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Comet added successfully!
                        </div>
                    <?php elseif ($_GET['success'] === 'comet-deleted'): ?>
                        <div class="alert alert-success success-notification show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Comet deleted successfully!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

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
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col" class="action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($comets)): ?>
                            <?php foreach ($comets as $comet): ?>
                                <tr>
                                    <td><?= $comet->getId() ?></td>
                                    <td>
                                        <?php if ($comet->getImage()): ?>
                                            <img src="../<?= htmlspecialchars($comet->getImage()) ?>" alt="<?= htmlspecialchars($comet->getName()) ?>"
                                                class="rounded-circle object-fit-cover" style="width: 80px; height: 80px;">
                                        <?php else: ?>
                                            <img src="../assets/images/no-image.png" alt="No image"
                                                class="rounded-circle object-fit-cover" style="width: 80px; height: 80px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($comet->getName()) ?></td>
                                    <td><?= $comet->getCategoryId() == 3 ? 'COMET' : $comet->getCategoryId() ?></td>
                                    <td class="action-column">
                                        <a href="#" class="btn btn-sm btn-warning edit-comet-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCometModal"
                                            data-comet-id="<?= $comet->getId() ?>"
                                            data-comet-name="<?= htmlspecialchars($comet->getName()) ?>"
                                            data-comet-category="<?= $comet->getCategoryId() ?>"
                                            data-comet-image="<?= $comet->getImage() ?>"
                                            data-comet-features="<?= htmlspecialchars($comet->getFeatures()) ?>"
                                            data-comet-orbital-period="<?= $comet->getOrbitalPeriodYears() ?>"
                                            data-comet-description="<?= htmlspecialchars($comet->getDescription()) ?>"
                                            data-comet-last-observed="<?= $comet->getLastObserved() ?>">
                                            <i class="bi bi-pencil-fill me-2"></i> Edit
                                        </a>
                                        <a href="../controllers/CometController.php?action=delete&id=<?= $comet->getId() ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Do you really want to delete this comet?');">
                                            <i class="bi bi-trash-fill me-2"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No comets found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </main>
        <footer class="mt-auto">
            <?php include('../admin/includes/AdminFooter.php'); ?>
        </footer>
    </div>

    <!-- Edit Comet Modal -->
    <div class="modal fade" id="editCometModal" tabindex="-1" aria-labelledby="editCometModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editCometForm" method="post" action="../controllers/CometController.php?action=update">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCometModalLabel">Edit Comet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" id="editCometId">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="editCometName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editCometName" name="name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="editCometCategory" class="form-label">Category</label>
                                <select class="form-select" id="editCometCategory" name="category_id" required disabled>
                                    <option value="3" selected>Comet</option>
                                </select>
                                <input type="hidden" name="category_id" value="3">
                            </div>

                            <div class="col-md-6">
                                <label for="editCometLastObserved" class="form-label">Last Observed</label>
                                <input type="date" class="form-control" id="editCometLastObserved" name="last_observed">
                            </div>

                            <div class="col-md-6">
                                <label for="editCometOrbitalPeriod" class="form-label">Orbital Period (years)</label>
                                <input type="number" step="0.01" class="form-control" id="editCometOrbitalPeriod" name="orbital_period_years">
                            </div>

                            <div class="col-md-6">
                                <label for="editCometImage" class="form-label">Comet Image</label>
                                <input type="file" class="form-control" id="editCometImage" name="image" accept="image/*" onchange="previewImage(this)">
                            </div>

                            <div class="col-md-6" id="imagePreviewContainer" style="display: none;">
                                <img id="imagePreview"
                                    src="image"
                                    alt="Image Preview"
                                    class="img-thumbnail"
                                    style="max-width: 200px; max-height: 200px; object-fit: cover;">
                            </div>

                            <div class="col-12">
                                <label for="editCometFeatures" class="form-label">Features</label>
                                <textarea class="form-control" id="editCometFeatures" name="features" rows="2"></textarea>
                            </div>

                            <div class="col-12">
                                <label for="editCometDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editCometDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Comet Modal -->
    <div class="modal fade" id="addCometModal" tabindex="-1" aria-labelledby="addCometModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addCometForm" method="post" action="../controllers/CometController.php?action=add">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCometModalLabel">Add New Comet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="addCometName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="addCometName" name="name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="addCometCategory" class="form-label">Category</label>
                                <select class="form-select" id="addCometCategory" name="category_id" required disabled>
                                    <option value="3" selected>Comet</option>
                                </select>
                                <input type="hidden" name="category_id" value="3">
                            </div>

                            <div class="col-md-6">
                                <label for="addCometLastObserved" class="form-label">Last Observed</label>
                                <input type="date" class="form-control" id="addCometLastObserved" name="last_observed">
                            </div>

                            <div class="col-md-6">
                                <label for="addCometOrbitalPeriod" class="form-label">Orbital Period (years)</label>
                                <input type="number" step="0.01" class="form-control" id="addCometOrbitalPeriod" name="orbital_period_years">
                            </div>

                            <div class="col-md-6">
                                <label for="addCometImage" class="form-label">Comet Image</label>
                                <input type="file" class="form-control" id="addCometImage" name="image" accept="image/*" onchange="previewImage(this)">
                            </div>

                            <div class="col-md-6" id="imagePreviewContainer" style="display: none;">
                                <img id="imagePreview"
                                    src="image"
                                    alt="Image Preview"
                                    class="img-thumbnail"
                                    style="max-width: 200px; max-height: 200px; object-fit: cover;">
                            </div>

                            <div class="col-12">
                                <label for="addCometFeatures" class="form-label">Features</label>
                                <textarea class="form-control" id="addCometFeatures" name="features" rows="2"></textarea>
                            </div>

                            <div class="col-12">
                                <label for="addCometDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="addCometDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Comet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/simple-notification.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editCometModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                // Lấy dữ liệu từ các data-* attributes
                const cometId = button.getAttribute('data-comet-id');
                const cometName = button.getAttribute('data-comet-name');
                const cometCategory = button.getAttribute('data-comet-category');
                const cometImage = button.getAttribute('data-comet-image');
                const cometLastObserved = button.getAttribute('data-comet-last-observed');
                const cometOrbitalPeriod = button.getAttribute('data-comet-orbital-period');
                const cometFeatures = button.getAttribute('data-comet-features');
                const cometDescription = button.getAttribute('data-comet-description');

                // Điền dữ liệu vào các trường trong modal
                document.getElementById('editCometId').value = cometId;
                document.getElementById('editCometName').value = cometName;
                document.getElementById('editCometCategory').value = cometCategory;
                document.getElementById('editCometLastObserved').value = cometLastObserved;
                document.getElementById('editCometOrbitalPeriod').value = cometOrbitalPeriod;
                document.getElementById('editCometFeatures').value = cometFeatures;
                document.getElementById('editCometDescription').value = cometDescription;

                // Xử lý hiển thị ảnh cũ
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');

                if (cometImage && cometImage !== 'null' && cometImage !== '') {
                    imagePreview.src = '../' + cometImage;
                    imagePreviewContainer.style.display = 'block';
                } else {
                    imagePreview.src = '../assets/images/no-image.png';
                    imagePreviewContainer.style.display = 'block';
                }
            });
        });

        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('imagePreviewContainer');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
            }
        }
    </script>

</body>

</html>