<?php
require_once __DIR__ . '/../models/ArticleModel.php';

class ArticleController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest($action, $data = []) {
        switch ($action) {
            case 'add':
                $this->handleImageUpload($data);
                $this->model->addArticle($data);
                header('Location: AdminArticle.php');
                break;
            case 'edit':
                $this->handleImageUpload($data);
                $this->model->updateArticle($data);
                header('Location: AdminArticle.php');
                break;
            case 'delete':
                if (!empty($data['id'])) {
                    $this->model->deleteArticle($data['id']);
                }
                header('Location: AdminArticle.php');
                break;
            default:
                echo 'Invalid action';
                break;
        }
    }

    private function handleImageUpload(&$data) {
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $tmpFile = $_FILES['image_file']['tmp_name'];
            $originalName = basename($_FILES['image_file']['name']);
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $uniqueName = uniqid('img_', true) . '.' . $ext;
            $destination = $uploadDir . $uniqueName;

            if (move_uploaded_file($tmpFile, $destination)) {
                $data['image_url'] = $uniqueName;
            }
        } elseif (isset($data['id'])) {
            // Keep existing image if no new upload during edit
            $existingArticle = $this->model->getArticleById($data['id']);
            $data['image_url'] = $existingArticle['image_url'] ?? null;
        }
    }
}
