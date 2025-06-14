<?php
require_once __DIR__ . '/../models/ConstellationModel.php';

class ConstellationController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest($action, $data, $file = null) {
        switch ($action) {
            case 'add':
                $this->model->addConstellation($data, $file);
                break;
            case 'edit':
                if (isset($data['id'])) {
                    $this->model->updateConstellation($data['id'], $data, $file);
                }
                break;
            case 'delete':
                if (isset($data['id'])) {
                    $this->model->deleteConstellation($data['id']);
                }
                break;
        }

        header('Location: AdminConstellation.php');
        exit;
    }

    public function getAllConstellations() {
        return $this->model->getAllConstellations();
    }

    public function getConstellationById($id) {
        return $this->model->getConstellationById($id);
    }

    public function countAll() {
        return $this->model->countAll();
    }

    public function getPaginatedConstellations($limit, $offset) {
        return $this->model->findPage($limit, $offset);
    }
}
