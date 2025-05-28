<?php
require_once __DIR__ . '/../models/ConstellationModel.php';

class ConstellationController {
    private $model;

    public function __construct($conn) {
        $this->model = new ConstellationModel($conn);
    }

    public function handleAdminRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add'])) {
                $this->model->create($_POST['name'], $_POST['description']);
            } elseif (isset($_POST['update'])) {
                $id = $_POST['id'] ?? null;
                if ($id) {
                    $this->model->update($id, $_POST['name'], $_POST['description']);
                }
            } elseif (isset($_POST['delete'])) {
                $id = $_POST['id'] ?? null;
                if ($id) {
                    $this->model->delete($id);
                }
            }
        }
    }

    public function getAllConstellations() {
        return $this->model->getAll();
    }
}
?>
