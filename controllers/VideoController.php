<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$path = dirname(__DIR__);
require_once $path . '/models/VideoModel.php';
require_once $path . '/entities/Video.php';

class VideoController
{
    private $videoModel;
    private $uploadDir = '../assets/videos/';

    public function __construct()
    {
        $this->videoModel = new VideoModel();
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function index()
    {
        try {
            $isAdmin = strpos($_SERVER['REQUEST_URI'], 'admin') !== false;

            if ($isAdmin) {
                $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                $perPage = 5;

                $result = $this->videoModel->getPaginatedVideos($page, $perPage);

                if (!isset($result['videos']) || !isset($result['total']) || !isset($result['total_pages'])) {
                    throw new Exception("Invalid pagination data");
                }

                return [
                    'status' => 'success',
                    'data' => [
                        'videos' => $result['videos'],
                        'total' => (int)$result['total'],
                        'total_pages' => (int)$result['total_pages'],
                        'current_page' => (int)$page
                    ]
                ];
            } else {
                $result = $this->videoModel->getAll();
                return ['status' => 'success', 'data' => ['videos' => $result]];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch videos: ' . $e->getMessage()];
        }
    }

    public function show($id)
    {
        if ($id <= 0) {
            return ['status' => 'error', 'message' => 'Invalid video ID'];
        }

        try {
            $video = $this->videoModel->getById($id);
            if ($video) {
                return ['status' => 'success', 'data' => $video];
            } else {
                return ['status' => 'error', 'message' => 'Video not found'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch video: ' . $e->getMessage()];
        }
    }

    public function add($data)
    {
        if (empty($data['title'])) {
            $this->redirectWithError('empty-video-title');
            return;
        }

        if (empty($data['url'])) {
            $this->redirectWithError('empty-video-url');
            return;
        }

        try {
            $video = new Video(
                $data['title'],
                $data['url'],
                $data['description'] ?? null,
                null
            );

            $id = $this->videoModel->create($video);
            if (!$id) {
                throw new Exception("Failed to create video");
            }

            if (!empty($_FILES['thumbnail']['name'])) {
                $uploadedFile = $this->handleImageUpload($_FILES['thumbnail'], $id);
                if (!$uploadedFile) {
                    throw new Exception("Failed to upload thumbnail");
                }
            }

            $this->redirectWithStatus('success', 'Video added successfully');
        } catch (Exception $e) {
            $this->redirectWithError('failed-to-add');
        }
    }

    private function handleImageUpload($file, $videoId): bool
    {
        try {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024;

            if (!file_exists($this->uploadDir)) {
                if (!mkdir($this->uploadDir, 0777, true)) {
                    throw new Exception("Failed to create upload directory");
                }
            }

            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileType = $file['type'];
                $fileSize = $file['size'];

                if (!in_array($fileType, $allowedTypes)) {
                    $this->redirectWithError('invalid-file-type');
                    return false;
                }

                if ($fileSize > $maxFileSize) {
                    $this->redirectWithError('file-too-large');
                    return false;
                }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('video_') . '.' . $extension;
                $filepath = $this->uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $video = $this->videoModel->getById($videoId);
                    if ($video) {
                        $video->setThumbnailUrl('assets/videos/' . $filename);
                        if (!$this->videoModel->update($video)) {
                            unlink($filepath);
                            throw new Exception("Failed to update video with thumbnail");
                        }
                    }
                    return true;
                } else {
                    throw new Exception("Failed to move uploaded file");
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        if (empty($data['title']) || !$id) {
            $this->redirectWithError('empty-video-title');
            return;
        }

        try {
            $video = $this->videoModel->getById($id);
            if (!$video) {
                $this->redirectWithError('video-not-found');
                return;
            }

            $video->setTitle($data['title']);
            $video->setUrl($data['url'] ?? null);
            $video->setDescription($data['description'] ?? null);

            if (isset($_POST['delete_image']) && $_POST['delete_image'] === '1') {
                $oldImageUrl = $video->getThumbnailUrl();
                if ($oldImageUrl) {
                    $oldImagePath = '../' . $oldImageUrl;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $video->setThumbnailUrl(null);
            }

            if (!empty($_FILES['thumbnail']['name'])) {
                $uploadedFile = $this->handleImageUpload($_FILES['thumbnail'], $id);
                if (!$uploadedFile) {
                    throw new Exception("Failed to upload thumbnail");
                }
            }

            if ($this->videoModel->update($video)) {
                $this->redirectWithStatus('success', 'Video updated successfully');
            } else {
                $this->redirectWithError('update-failed');
            }
        } catch (Exception $e) {
            $this->redirectWithError('update-failed');
        }
    }

    public function delete($id)
    {
        if (!$id) {
            $this->redirectWithError('invalid-video-id');
            return;
        }

        try {
            $success = $this->videoModel->delete($id);
            if ($success) {
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $totalItems = $this->videoModel->getTotalCount();
                $perPage = 5;
                $totalPages = ceil($totalItems / $perPage);

                if ($currentPage > $totalPages && $currentPage > 1) {
                    $currentPage = $totalPages;
                }

                $this->redirectWithStatus('success', 'Video deleted successfully');
            } else {
                $this->redirectWithError('delete-failed');
            }
        } catch (Exception $e) {
            $this->redirectWithError('delete-failed');
        }
    }

    private function redirectWithStatus($status, $message)
    {
        $successMessages = [
            'Video added successfully' => 'video-added',
            'Video updated successfully' => 'video-updated',
            'Video deleted successfully' => 'video-deleted'
        ];

        $successKey = $successMessages[$message] ?? 'unknown-success';
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        header("Location: ../admin/AdminVideo.php?success=$successKey&page=$currentPage");
        exit;
    }

    private function redirectWithError($error)
    {
        $errorMessages = [
            'empty-video-title' => 'empty-video-title',
            'empty-video-url' => 'empty-video-url',
            'invalid-video-id' => 'invalid-video-id',
            'video-not-found' => 'video-not-found',
            'failed-to-add' => 'failed-to-add',
            'update-failed' => 'update-failed',
            'delete-failed' => 'delete-failed',
            'invalid-file-type' => 'invalid-file-type',
            'file-too-large' => 'file-too-large',
            'upload-failed' => 'upload-failed'
        ];

        $errorKey = $errorMessages[$error] ?? 'failed-to-add';
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        header("Location: ../admin/AdminVideo.php?error=$errorKey&page=$currentPage");
        exit;
    }
}

// ================== XỬ LÝ REQUEST ==================

$controller = new VideoController();

// Ưu tiên lấy action từ POST, nếu không có thì lấy từ GET
$action = $_POST['action'] ?? ($_GET['action'] ?? 'index');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($action) {
            case 'index':
                $controller->index();
                break;

            case 'show':
                if (isset($_GET['id'])) {
                    $controller->show((int)$_GET['id']);
                } else {
                    header('Location: ../admin/AdminVideo.php?error=missing-id');
                }
                break;

            case 'delete':
                if (isset($_GET['id'])) {
                    $controller->delete((int)$_GET['id']);
                } else {
                    header('Location: ../admin/AdminVideo.php?error=missing-id');
                }
                break;

            default:
                header('Location: ../admin/AdminVideo.php?error=invalid-action');
                break;
        }
        break;

    case 'POST':
        $data = [
            'title' => $_POST['title'] ?? null,
            'url' => $_POST['url'] ?? null,
            'description' => $_POST['description'] ?? null
        ];

        switch ($action) {
            case 'add':
                $controller->add($data);
                break;

            case 'update':
                if (isset($_POST['id'])) {
                    $controller->update((int)$_POST['id'], $data);
                } else {
                    header('Location: ../admin/AdminVideo.php?error=missing-id');
                }
                break;

            default:
                header('Location: ../admin/AdminVideo.php?error=invalid-action');
                break;
        }
        break;

    default:
        header('Location: ../admin/AdminVideo.php?error=invalid-request-method');
        break;
}
