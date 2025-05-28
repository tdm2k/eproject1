<?php
require_once __DIR__ . '/../models/ArticleModel.php';

class ArticleController {
    private $model;

    public function __construct($model = null) {
        $this->model = $model ?? new ArticleModel();
    }

    public function handleRequest($action, $data) {
        switch ($action) {
            case 'add':
                $this->model->addArticle($data);
                break;
            case 'edit':
                $this->model->updateArticle($data);
                break;
            case 'delete':
                $this->model->deleteArticle($data['id']);
                break;
        }

        // Quay lại trang admin sau khi xử lý
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
