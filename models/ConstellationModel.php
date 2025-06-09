<?php
require_once __DIR__ . '/../connection.php';

class ConstellationModel {
    private $conn;

    public function __construct($conn = null) {
        $this->conn = $conn ?: (new Connection())->getConnection();
    }

    public function getAllConstellations() {
        $stmt = $this->conn->prepare("SELECT * FROM constellations ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConstellationById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM constellations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addConstellation($data) {
        $stmt = $this->conn->prepare("INSERT INTO constellations (name, image, description, notable_stars, category_id, position, legend) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['image'] ?? '',
            $data['description'],
            $data['notable_stars'] ?? '',
            !empty($data['category_id']) ? $data['category_id'] : null,
            $data['position'] ?? '',
            $data['legend'] ?? ''
        ]);
    }

    public function updateConstellation($id, $data) {
        $stmt = $this->conn->prepare("UPDATE constellations SET name = ?, image = ?, description = ?, notable_stars = ?, category_id = ?, position = ?, legend = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['image'] ?? '',
            $data['description'],
            $data['notable_stars'] ?? '',
            !empty($data['category_id']) ? $data['category_id'] : null,
            $data['position'] ?? '',
            $data['legend'] ?? '',
            $id
        ]);
    }

    public function deleteConstellation($id) {
        $stmt = $this->conn->prepare("DELETE FROM constellations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
