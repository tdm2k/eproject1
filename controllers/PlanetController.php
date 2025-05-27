<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$path = dirname(__DIR__);
require_once $path . '/models/PlanetModel.php';
require_once $path . '/entities/Planet.php';

class PlanetController {
    private $planetModel;

    public function __construct() {
        $this->planetModel = new PlanetModel();
    }

    public function index() {
        try {
            // Check if this is an admin request
            $isAdmin = strpos($_SERVER['REQUEST_URI'], 'admin') !== false;
            
            if ($isAdmin) {
                // For admin page, use pagination
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $perPage = 5;
                $result = $this->planetModel->getPaginatedPlanets($page, $perPage);
                return ['status' => 'success', 'data' => $result];
            } else {
                // For public page, show all planets
                $result = $this->planetModel->getAllPlanets();
                return ['status' => 'success', 'data' => ['planets' => $result]];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch planets: ' . $e->getMessage()];
        }
    }

    public function show($id) {
        if ($id <= 0) {
            return ['status' => 'error', 'message' => 'Invalid planet ID'];
        }

        try {
            $planet = $this->planetModel->getPlanetById($id);
            if ($planet) {
                return ['status' => 'success', 'data' => $planet];
            } else {
                return ['status' => 'error', 'message' => 'Planet not found'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch planet: ' . $e->getMessage()];
        }
    }

    public function add($data) {
        if (empty($data['name'])) {
            $this->redirectWithError('empty-planet-name');
            return;
        }

        try {
            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/images/planets/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = $_FILES['image']['type'];
                if (!in_array($fileType, $allowedTypes)) {
                    $this->redirectWithError('invalid-file-type');
                    return;
                }

                // Validate file size (max 5MB)
                $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
                if ($_FILES['image']['size'] > $maxFileSize) {
                    $this->redirectWithError('file-too-large');
                    return;
                }

                // Generate unique filename
                $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('planet_') . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = 'assets/images/planets/' . $fileName;
                } else {
                    $this->redirectWithError('upload-failed');
                    return;
                }
            }

            $success = $this->planetModel->addPlanet($data);
            if ($success) {
                $this->redirectWithStatus('success', 'Planet added successfully');
            } else {
                $this->redirectWithError('add-failed: Database insertion failed');
            }
        } catch (Exception $e) {
            error_log("Error in add method: " . $e->getMessage());
            $this->redirectWithError('add-failed: ' . $e->getMessage());
        }
    }

    public function update($id, $data) {
        if (empty($data['name']) || !$id) {
            $this->redirectWithError('empty-planet-name');
            return;
        }

        try {
            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/images/planets/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = $_FILES['image']['type'];
                if (!in_array($fileType, $allowedTypes)) {
                    $this->redirectWithError('invalid-file-type');
                    return;
                }

                // Validate file size (max 5MB)
                $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
                if ($_FILES['image']['size'] > $maxFileSize) {
                    $this->redirectWithError('file-too-large');
                    return;
                }

                // Get old image path to delete it later
                $oldPlanet = $this->planetModel->getPlanetById($id);
                $oldImagePath = $oldPlanet ? $oldPlanet->getImage() : null;

                // Generate unique filename
                $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('planet_') . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = 'assets/images/planets/' . $fileName;
                    
                    // Delete old image if exists
                    if ($oldImagePath && file_exists('../' . $oldImagePath)) {
                        unlink('../' . $oldImagePath);
                    }
                } else {
                    $this->redirectWithError('upload-failed');
                    return;
                }
            }

            $success = $this->planetModel->updatePlanet((int)$id, $data);
            if ($success) {
                $this->redirectWithStatus('success', 'Planet updated successfully');
            } else {
                $this->redirectWithError('update-failed');
            }
        } catch (Exception $e) {
            error_log("Error in update method: " . $e->getMessage());
            $this->redirectWithError('update-failed: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        if (!$id) {
            $this->redirectWithError('invalid-planet-id');
            return;
        }

        try {
            $success = $this->planetModel->softDeletePlanet((int)$id);
            if ($success) {
                $this->redirectWithStatus('success', 'Planet deleted successfully');
            } else {
                $this->redirectWithError('delete-failed');
            }
        } catch (Exception $e) {
            $this->redirectWithError('delete-failed: ' . $e->getMessage());
        }
    }

    public function getDeletedPlanets() {
        try {
            $planets = $this->planetModel->getDeletedPlanets();
            return ['status' => 'success', 'data' => $planets];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch deleted planets: ' . $e->getMessage()];
        }
    }

    public function restore($id) {
        if (!$id) {
            $this->redirectWithError('invalid-planet-id');
            return;
        }

        try {
            $success = $this->planetModel->restorePlanet((int)$id);
            if ($success) {
                $this->redirectWithStatus('success', 'Planet restored successfully');
            } else {
                $this->redirectWithError('restore-failed');
            }
        } catch (Exception $e) {
            $this->redirectWithError('restore-failed: ' . $e->getMessage());
        }
    }

    public function forceDelete($id) {
        if (!$id) {
            $this->redirectWithError('invalid-planet-id');
            return;
        }

        try {
            $success = $this->planetModel->forceDeletePlanet((int)$id);
            if ($success) {
                $this->redirectWithStatus('success', 'Planet permanently deleted');
            } else {
                $this->redirectWithError('delete-failed');
            }
        } catch (Exception $e) {
            $this->redirectWithError('delete-failed: ' . $e->getMessage());
        }
    }

    private function redirectWithStatus($status, $message) {
        $successMessages = [
            'Planet added successfully' => 'planet-added',
            'Planet updated successfully' => 'planet-updated',
            'Planet deleted successfully' => 'planet-deleted',
            'Planet restored successfully' => 'planet-restored',
            'Planet permanently deleted' => 'planet-permanently-deleted'
        ];
        
        $successKey = $successMessages[$message] ?? 'unknown-success';
        header("Location: ../admin/AdminPlanet.php?success=$successKey");
        exit;
    }

    private function redirectWithError($error) {
        $errorMessages = [
            'empty-planet-name' => 'empty-planet-name',
            'invalid-planet-id' => 'invalid-planet-id',
            'invalid-file-type' => 'invalid-file-type',
            'file-too-large' => 'file-too-large',
            'upload-failed' => 'upload-failed',
            'add-failed' => 'add-failed',
            'update-failed' => 'update-failed',
            'delete-failed' => 'delete-failed',
            'restore-failed' => 'restore-failed'
        ];

        $errorKey = $errorMessages[$error] ?? 'unknown-error';
        header("Location: ../admin/AdminPlanet.php?error=$errorKey");
        exit;
    }
}

// ================== XỬ LÝ REQUEST ==================

$controller = new PlanetController();
$action = $_GET['action'] ?? 'index';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($action === 'index') {
            $controller->index();
        } elseif ($action === 'show' && isset($_GET['id'])) {
            $controller->show((int)$_GET['id']);
        } elseif ($action === 'delete' && isset($_GET['id'])) {
            $controller->delete((int)$_GET['id']);
        } elseif ($action === 'restore' && isset($_GET['id'])) {
            $controller->restore((int)$_GET['id']);
        } elseif ($action === 'forceDelete' && isset($_GET['id'])) {
            $controller->forceDelete((int)$_GET['id']);
        } else {
            header('Location: ../admin/AdminPlanet.php?error=invalid-action');
        }
        break;

    case 'POST':
        $action = $_POST['action'] ?? 'index';
        $data = [
            'name' => $_POST['name'] ?? null,
            'description' => $_POST['description'] ?? null,
            'potential_for_life' => $_POST['potential_for_life'] ?? null,
            'orbit_and_rotation' => $_POST['orbit_and_rotation'] ?? null,
            'rings' => isset($_POST['rings']) ? (int)$_POST['rings'] : 0,
            'structure' => $_POST['structure'] ?? null,
            'atmosphere' => $_POST['atmosphere'] ?? null,
            'name_sake' => $_POST['name_sake'] ?? null,
            'size_and_distance' => $_POST['size_and_distance'] ?? null,
            'moons' => $_POST['moons'] ?? null,
            'formation' => $_POST['formation'] ?? null,
            'surface' => $_POST['surface'] ?? null,
            'magnetosphere' => $_POST['magnetosphere'] ?? null,
            'category_id' => isset($_POST['category_id']) ? (int)$_POST['category_id'] : null
        ];

        if ($action === 'add') {
            $controller->add($data);
        } elseif ($action === 'update' && isset($_POST['id'])) {
            $controller->update((int)$_POST['id'], $data);
        } else {
            header('Location: ../admin/AdminPlanet.php?error=invalid-action');
        }
        break;

    default:
        header('Location: ../admin/AdminPlanet.php?error=invalid-request-method');
        break;
}
?>
