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

    public function addConstellation($data, $imageFile = null) {
        $imageName = $this->handleImageUpload($imageFile);

        $stmt = $this->conn->prepare("INSERT INTO constellations (name, image, description, notable_stars, category_id, position, legend) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $imageName,
            $data['description'],
            $data['notable_stars'] ?? '',
            !empty($data['category_id']) ? $data['category_id'] : null,
            $data['position'] ?? '',
            $data['legend'] ?? ''
        ]);
    }

    public function updateConstellation($id, $data, $imageFile = null) {
        $existing = $this->getConstellationById($id);
        $imageName = $existing['image'];

        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            // Xóa ảnh cũ nếu tồn tại
            $oldPath = __DIR__ . '/../uploads/' . $existing['image'];
            if (!empty($existing['image']) && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $imageName = $this->handleImageUpload($imageFile);
        }

        $stmt = $this->conn->prepare("UPDATE constellations SET name = ?, image = ?, description = ?, notable_stars = ?, category_id = ?, position = ?, legend = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $imageName,
            $data['description'],
            $data['notable_stars'] ?? '',
            !empty($data['category_id']) ? $data['category_id'] : null,
            $data['position'] ?? '',
            $data['legend'] ?? '',
            $id
        ]);
    }

    public function deleteConstellation($id) {
        $existing = $this->getConstellationById($id);
        if ($existing && !empty($existing['image'])) {
            $path = __DIR__ . '/../uploads/' . $existing['image'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $stmt = $this->conn->prepare("DELETE FROM constellations WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function countAll() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM constellations");
        return (int)$stmt->fetchColumn();
    }

    public function findPage($limit, $offset) {
        $stmt = $this->conn->prepare("SELECT * FROM constellations ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function handleImageUpload($file) {
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../uploads/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($file['name']);
            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                return $fileName;
            }
        }
        return null;
    }
}
