<?php
require_once __DIR__ . '/../entities/Constellation.php';

class ConstellationModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM constellations");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Constellation::fromArray($row);
        }
        return $result;
    }

    public function create($name, $description) {
        $stmt = $this->conn->prepare("INSERT INTO constellations (name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }

    public function update($id, $name, $description) {
        $stmt = $this->conn->prepare("UPDATE constellations SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM constellations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
