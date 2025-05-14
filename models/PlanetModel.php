<?php

$rootPath = dirname(__DIR__);
require_once $rootPath . '/connection.php';
require_once $rootPath . '/entities/Planet.php';

class PlanetModel
{
    private $conn;
    private $table = "planets";

    public function __construct()
    {
        $database = new Connection();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả hành tinh (không bao gồm đã xóa mềm)
    public function getAllPlanets(): array
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM $this->table p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.is_deleted = 0 
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $planets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $planets[] = Planet::fromArray($row);
        }
        return $planets;
    }

    // Lấy một hành tinh theo ID
    public function getPlanetById(int $id): ?Planet
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM $this->table p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.id = ? AND p.is_deleted = 0 
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? Planet::fromArray($row) : null;
    }

    // Thêm hành tinh mới
    public function addPlanet(array $data): bool
    {
        $query = "INSERT INTO $this->table (
            name, image, description, potential_for_life, orbit_and_rotation, rings, 
            structure, atmosphere, name_sake, size_and_distance, moons, formation, 
            surface, magnetosphere, category_id
        ) VALUES (
            :name, :image, :description, :potential_for_life, :orbit_and_rotation, :rings, 
            :structure, :atmosphere, :name_sake, :size_and_distance, :moons, :formation, 
            :surface, :magnetosphere, :category_id
        )";
        $stmt = $this->conn->prepare($query);

        $params = [
            ':name' => $this->sanitize($data['name'] ?? null),
            ':image' => $this->sanitize($data['image'] ?? null),
            ':description' => $this->sanitize($data['description'] ?? null),
            ':potential_for_life' => $this->sanitize($data['potential_for_life'] ?? null),
            ':orbit_and_rotation' => $this->sanitize($data['orbit_and_rotation'] ?? null),
            ':rings' => isset($data['rings']) ? (int)$data['rings'] : 0,
            ':structure' => $this->sanitize($data['structure'] ?? null),
            ':atmosphere' => $this->sanitize($data['atmosphere'] ?? null),
            ':name_sake' => $this->sanitize($data['name_sake'] ?? null),
            ':size_and_distance' => $this->sanitize($data['size_and_distance'] ?? null),
            ':moons' => $this->sanitize($data['moons'] ?? null),
            ':formation' => $this->sanitize($data['formation'] ?? null),
            ':surface' => $this->sanitize($data['surface'] ?? null),
            ':magnetosphere' => $this->sanitize($data['magnetosphere'] ?? null),
            ':category_id' => isset($data['category_id']) ? (int)$data['category_id'] : null
        ];

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    // Cập nhật hành tinh
    public function updatePlanet(int $id, array $data): bool
    {
        $query = "UPDATE $this->table 
                  SET name = :name, image = :image, description = :description, 
                      potential_for_life = :potential_for_life, orbit_and_rotation = :orbit_and_rotation, 
                      rings = :rings, structure = :structure, atmosphere = :atmosphere, 
                      name_sake = :name_sake, size_and_distance = :size_and_distance, 
                      moons = :moons, formation = :formation, surface = :surface, 
                      magnetosphere = :magnetosphere, category_id = :category_id 
                  WHERE id = :id AND is_deleted = 0";
        $stmt = $this->conn->prepare($query);

        $params = [
            ':id' => $id,
            ':name' => $this->sanitize($data['name'] ?? null),
            ':image' => $this->sanitize($data['image'] ?? null),
            ':description' => $this->sanitize($data['description'] ?? null),
            ':potential_for_life' => $this->sanitize($data['potential_for_life'] ?? null),
            ':orbit_and_rotation' => $this->sanitize($data['orbit_and_rotation'] ?? null),
            ':rings' => isset($data['rings']) ? (int)$data['rings'] : 0,
            ':structure' => $this->sanitize($data['structure'] ?? null),
            ':atmosphere' => $this->sanitize($data['atmosphere'] ?? null),
            ':name_sake' => $this->sanitize($data['name_sake'] ?? null),
            ':size_and_distance' => $this->sanitize($data['size_and_distance'] ?? null),
            ':moons' => $this->sanitize($data['moons'] ?? null),
            ':formation' => $this->sanitize($data['formation'] ?? null),
            ':surface' => $this->sanitize($data['surface'] ?? null),
            ':magnetosphere' => $this->sanitize($data['magnetosphere'] ?? null),
            ':category_id' => isset($data['category_id']) ? (int)$data['category_id'] : null
        ];

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    // Xóa mềm hành tinh
    public function softDeletePlanet(int $id): bool
    {
        $query = "UPDATE $this->table SET is_deleted = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Lấy danh sách danh mục
    public function getCategories(): array
    {
        $query = "SELECT id, name FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm sanitize dữ liệu
    private function sanitize(?string $input): ?string
    {
        return $input !== null ? htmlspecialchars(strip_tags($input)) : null;
    }

    // Lấy danh sách hành tinh đã xóa mềm
    public function getDeletedPlanets(): array
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM $this->table p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.is_deleted = 1 
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $planets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $planets[] = Planet::fromArray($row);
        }
        return $planets;
    }

    // Khôi phục hành tinh đã xóa mềm
    public function restorePlanet(int $id): bool
    {
        $query = "UPDATE $this->table SET is_deleted = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa vĩnh viễn hành tinh
    public function forceDeletePlanet(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>