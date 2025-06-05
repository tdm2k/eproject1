<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$path = dirname(__DIR__);
require_once $path . '/models/ObservatoryModel.php';
require_once $path . '/entities/Observatory.php';

class ObservatoryController {
    private $observatoryModel;
    private $uploadDir = '../assets/observatories/';

    public function __construct() {
        $this->observatoryModel = new ObservatoryModel();
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function index() {
        try {
            // Check if this is an admin request
            $isAdmin = strpos($_SERVER['REQUEST_URI'], 'admin') !== false;
            
            if ($isAdmin) {
                // For admin page, use pagination
                $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                $perPage = 5;
                
                // Debug log
                error_log("Admin request - Page: $page, Per page: $perPage");
                
                $result = $this->observatoryModel->getPaginatedObservatories($page, $perPage);
                
                // Debug log
                error_log("Pagination result: " . print_r($result, true));
                
                if (!isset($result['observatories']) || !isset($result['total']) || !isset($result['total_pages'])) {
                    error_log("Missing pagination data in result");
                    throw new Exception("Invalid pagination data");
                }
                
                return [
                    'status' => 'success',
                    'data' => [
                        'observatories' => $result['observatories'],
                        'total' => (int)$result['total'],
                        'total_pages' => (int)$result['total_pages'],
                        'current_page' => (int)$page
                    ]
                ];
            } else {
                // For public page, show all observatories
                $result = $this->observatoryModel->getAll();
                return ['status' => 'success', 'data' => ['observatories' => $result]];
            }
        } catch (Exception $e) {
            error_log("Error in index method: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Failed to fetch observatories: ' . $e->getMessage()];
        }
    }

    public function show($id) {
        if ($id <= 0) {
            return ['status' => 'error', 'message' => 'Invalid observatory ID'];
        }

        try {
            $observatory = $this->observatoryModel->getById($id);
            if ($observatory) {
                return ['status' => 'success', 'data' => $observatory];
            } else {
                return ['status' => 'error', 'message' => 'Observatory not found'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch observatory: ' . $e->getMessage()];
        }
    }

    public function add($data) {
        if (empty($data['name'])) {
            error_log("Add Observatory Error: Empty name");
            $this->redirectWithError('empty-observatory-name');
            return;
        }

        if (empty($data['location'])) {
            error_log("Add Observatory Error: Empty location");
            $this->redirectWithError('empty-observatory-location');
            return;
        }

        try {
            // Log input data
            error_log("Add Observatory Input Data: " . print_r($data, true));
            error_log("Add Observatory Files: " . print_r($_FILES, true));

            // Create observatory
            $observatory = new Observatory(
                $data['name'],
                $data['location'] ?? null,
                $data['description'] ?? null,
                null // image_url will be set after upload
            );

            error_log("Add Observatory: Attempting to create observatory");
            $id = $this->observatoryModel->create($observatory);
            if (!$id) {
                error_log("Add Observatory Error: Failed to create observatory record");
                throw new Exception("Failed to create observatory");
            }
            error_log("Add Observatory: Created observatory with ID: " . $id);

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                error_log("Add Observatory: Processing image upload");
                $uploadedFile = $this->handleImageUpload($_FILES['image'], $id);
                if (!$uploadedFile) {
                    error_log("Add Observatory Error: Failed to upload image");
                    throw new Exception("Failed to upload image");
                }
                error_log("Add Observatory: Successfully uploaded image");
            } else {
                error_log("Add Observatory: No image to upload");
            }

            error_log("Add Observatory: Successfully added observatory");
            $this->redirectWithStatus('success', 'Observatory added successfully');

        } catch (Exception $e) {
            error_log("Add Observatory Error: " . $e->getMessage());
            error_log("Add Observatory Error Trace: " . $e->getTraceAsString());
            $this->redirectWithError('failed-to-add');
        }
    }

    private function handleImageUpload($file, $observatoryId): bool {
        try {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB

            // Create upload directory if it doesn't exist
            if (!file_exists($this->uploadDir)) {
                error_log("Creating upload directory: " . $this->uploadDir);
                if (!mkdir($this->uploadDir, 0777, true)) {
                    error_log("Failed to create upload directory: " . $this->uploadDir);
                    throw new Exception("Failed to create upload directory");
                }
            }

            if ($file['error'] === UPLOAD_ERR_OK) {
                error_log("Processing file: " . $file['name']);
                $fileType = $file['type'];
                $fileSize = $file['size'];

                // Validate file type and size
                if (!in_array($fileType, $allowedTypes)) {
                    error_log("Invalid file type: " . $fileType);
                    $this->redirectWithError('invalid-file-type');
                    return false;
                }

                if ($fileSize > $maxFileSize) {
                    error_log("File too large: " . $fileSize . " bytes");
                    $this->redirectWithError('file-too-large');
                    return false;
                }

                // Generate unique filename
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('observatory_') . '.' . $extension;
                $filepath = $this->uploadDir . $filename;

                error_log("Moving uploaded file to: " . $filepath);
                // Move uploaded file
                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    // Update observatory with image URL
                    $observatory = $this->observatoryModel->getById($observatoryId);
                    if ($observatory) {
                        $observatory->setImageUrl('assets/observatories/' . $filename);
                        if (!$this->observatoryModel->update($observatory)) {
                            error_log("Failed to update observatory with image URL");
                            unlink($filepath);
                            throw new Exception("Failed to update observatory with image URL");
                        }
                    }
                    error_log("Successfully processed file: " . $file['name']);
                    return true;
                } else {
                    error_log("Failed to move uploaded file: " . $file['name']);
                    throw new Exception("Failed to move uploaded file");
                }
            } else {
                error_log("File upload error: " . $file['error'] . " for file: " . $file['name']);
                return false;
            }
        } catch (Exception $e) {
            error_log("Image Upload Error: " . $e->getMessage());
            error_log("Image Upload Error Trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    public function update($id, $data) {
        if (empty($data['name']) || !$id) {
            $this->redirectWithError('empty-observatory-name');
            return;
        }

        try {
            $observatory = $this->observatoryModel->getById($id);
            if (!$observatory) {
                $this->redirectWithError('observatory-not-found');
                return;
            }

            $observatory->setName($data['name']);
            $observatory->setLocation($data['location'] ?? null);
            $observatory->setDescription($data['description'] ?? null);

            // Handle image deletion
            if (isset($_POST['delete_image']) && $_POST['delete_image'] === '1') {
                $oldImageUrl = $observatory->getImageUrl();
                if ($oldImageUrl) {
                    $oldImagePath = '../' . $oldImageUrl;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $observatory->setImageUrl(null);
            }

            // Handle new image upload
            if (!empty($_FILES['image']['name'])) {
                $uploadedFile = $this->handleImageUpload($_FILES['image'], $id);
                if (!$uploadedFile) {
                    throw new Exception("Failed to upload image");
                }
            }

            if ($this->observatoryModel->update($observatory)) {
                $this->redirectWithStatus('success', 'Observatory updated successfully');
            } else {
                $this->redirectWithError('update-failed');
            }
        } catch (Exception $e) {
            error_log("Error in update method: " . $e->getMessage());
            $this->redirectWithError('update-failed');
        }
    }

    public function delete($id) {
        if (!$id) {
            $this->redirectWithError('invalid-observatory-id');
            return;
        }

        try {
            $success = $this->observatoryModel->delete($id);
            if ($success) {
                // Get current page from URL
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                
                // If we deleted the last item on the current page and it's not page 1,
                // redirect to the previous page
                $totalItems = $this->observatoryModel->getTotalCount();
                $perPage = 5;
                $totalPages = ceil($totalItems / $perPage);
                
                if ($currentPage > $totalPages && $currentPage > 1) {
                    $currentPage = $totalPages;
                }
                
                $this->redirectWithStatus('success', 'Observatory deleted successfully');
            } else {
                $this->redirectWithError('delete-failed');
            }
        } catch (Exception $e) {
            $this->redirectWithError('delete-failed');
        }
    }

    private function redirectWithStatus($status, $message) {
        $successMessages = [
            'Observatory added successfully' => 'observatory-added',
            'Observatory updated successfully' => 'observatory-updated',
            'Observatory deleted successfully' => 'observatory-deleted'
        ];
        
        $successKey = $successMessages[$message] ?? 'unknown-success';
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        header("Location: ../admin/AdminObservatory.php?success=$successKey&page=$currentPage");
        exit;
    }

    private function redirectWithError($error) {
        $errorMessages = [
            'empty-observatory-name' => 'empty-observatory-name',
            'empty-observatory-location' => 'empty-observatory-location',
            'invalid-observatory-id' => 'invalid-observatory-id',
            'observatory-not-found' => 'observatory-not-found',
            'failed-to-add' => 'failed-to-add',
            'update-failed' => 'update-failed',
            'delete-failed' => 'delete-failed',
            'invalid-file-type' => 'invalid-file-type',
            'file-too-large' => 'file-too-large',
            'upload-failed' => 'upload-failed'
        ];

        $errorKey = $errorMessages[$error] ?? 'failed-to-add';
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        header("Location: ../admin/AdminObservatory.php?error=$errorKey&page=$currentPage");
        exit;
    }
}

// ================== XỬ LÝ REQUEST ==================

$controller = new ObservatoryController();
$action = $_GET['action'] ?? 'index';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($action === 'index') {
            $controller->index();
        } elseif ($action === 'show' && isset($_GET['id'])) {
            $controller->show((int)$_GET['id']);
        } elseif ($action === 'delete' && isset($_GET['id'])) {
            $controller->delete((int)$_GET['id']);
        } else {
            header('Location: ../admin/AdminObservatory.php?error=invalid-action');
        }
        break;

    case 'POST':
        $action = $_POST['action'] ?? 'index';
        $data = [
            'name' => $_POST['name'] ?? null,
            'location' => $_POST['location'] ?? null,
            'description' => $_POST['description'] ?? null
        ];

        if ($action === 'add') {
            $controller->add($data);
        } elseif ($action === 'update' && isset($_POST['id'])) {
            $controller->update((int)$_POST['id'], $data);
        } else {
            header('Location: ../admin/AdminObservatory.php?error=invalid-action');
        }
        break;

    default:
        header('Location: ../admin/AdminObservatory.php?error=invalid-request-method');
        break;
}
?>
