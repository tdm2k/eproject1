<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/ObservatoryModel.php';
require_once __DIR__ . '/../entities/Observatory.php';

class ObservatoryController {
    private $model;
    private $uploadDir = '../assets/observatories/';

    public function __construct() {
        $this->model = new ObservatoryModel();
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

        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            return null;
        }

        if ($file['size'] > 5000000) {
            return null;
        }

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowedTypes)) {
            return null;
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'assets/observatories/' . $fileName;
        }

        return null;
    }

    public function index() {
        try {
            $observatories = $this->model->getAllObservatories();
            return ['status' => 'success', 'data' => $observatories];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function show($id) {
        try {
            if (!$id) {
                return ['status' => 'error', 'message' => 'Invalid observatory ID'];
            }
            $obs = $this->model->getObservatoryById($id);
            if ($obs) {
                return ['status' => 'success', 'data' => $obs];
            }
            return ['status' => 'error', 'message' => 'Observatory not found'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function add($data) {
        try {
            if (empty($data['name'])) {
                return ['status' => 'error', 'message' => 'Observatory name cannot be empty'];
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
                if ($imagePath) {
                    $data['image_url'] = $imagePath;
                }
            }

            $id = $this->model->addObservatory($data);
            if ($id) {
                return ['status' => 'success', 'message' => 'Observatory added successfully', 'data' => $id];
            }
            return ['status' => 'error', 'message' => 'Failed to add observatory'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function update($id, $data) {
        try {
            if (!$id) {
                return ['status' => 'error', 'message' => 'Invalid observatory ID'];
            }
            if (empty($data['name'])) {
                return ['status' => 'error', 'message' => 'Observatory name cannot be empty'];
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
                if ($imagePath) {
                    $data['image_url'] = $imagePath;
                }
            }

            $success = $this->model->updateObservatory($id, $data);
            if ($success) {
                return ['status' => 'success', 'message' => 'Observatory updated successfully'];
            }
            return ['status' => 'error', 'message' => 'Failed to update observatory'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function delete($id) {
        try {
            if (!$id) {
                return ['status' => 'error', 'message' => 'Invalid observatory ID'];
            }

            $success = $this->model->deleteObservatory($id);
            if ($success) {
                return ['status' => 'success', 'message' => 'Observatory deleted successfully'];
            }
            return ['status' => 'error', 'message' => 'Failed to delete observatory'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? $_POST['action'] ?? null;

        if (!$action) {
            header('Location: ../admin/AdminObservatory.php?error=invalid-action');
            exit;
        }

        switch ($action) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    header('Location: ../admin/AdminObservatory.php?error=invalid-request-method');
                    exit;
                }
                $result = $this->add($_POST);
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    header('Location: ../admin/AdminObservatory.php?error=invalid-request-method');
                    exit;
                }
                $result = $this->update($_POST['id'], $_POST);
                break;

            case 'delete':
                if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                    header('Location: ../admin/AdminObservatory.php?error=invalid-request-method');
                    exit;
                }
                $result = $this->delete($_GET['id']);
                break;

            default:
                header('Location: ../admin/AdminObservatory.php?error=invalid-action');
                exit;
        }

        if ($result['status'] === 'success') {
            header('Location: ../admin/AdminObservatory.php?status=success&message=' . urlencode($result['message']));
        } else {
            header('Location: ../admin/AdminObservatory.php?error=' . urlencode($result['message']));
        }
        exit;
    }
}

// Handle the request if accessed directly
if (basename($_SERVER['PHP_SELF']) === 'ObservatoryController.php') {
    $controller = new ObservatoryController();
    $controller->handleRequest();
}
