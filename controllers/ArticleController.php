<?php
require_once __DIR__ . '/../models/ArticleModel.php';

class ArticleController {
    private $model;

    public function createArticle($data) {
    $this->model->createArticle($data);
    }

    public function updateArticle($data) {
    $this->model->updateArticle($data);
    }


    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest($action, $data = []) {
        switch ($action) {
            case 'add':
                $this->model->addArticle($data);
                header('Location: AdminArticle.php');
                break;
            case 'edit':
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
                echo 'Hành động không hợp lệ';
                break;
        }
    }
}
