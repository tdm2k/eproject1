<?php
require_once __DIR__ . '/../models/ConstellationModel.php';

class ConstellationController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest($action, $data) {
        switch ($action) {
            case 'add':
                $this->model->addConstellation($data);
                header('Location: AdminConstellation.php');
                exit;
            case 'edit':
                if (isset($data['id'])) {
                    $this->model->updateConstellation($data['id'], $data);
                }
                header('Location: AdminConstellation.php');
                exit;
            case 'delete':
                if (isset($data['id'])) {
                    $this->model->deleteConstellation($data['id']);
                }
                header('Location: AdminConstellation.php');
                exit;
        }
    }

    public function getAllConstellations() {
        return $this->model->getAllConstellations();
    }

    public function getConstellationById($id) {
        return $this->model->getConstellationById($id);
    }
}
