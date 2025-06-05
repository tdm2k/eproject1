<?php

declare(strict_types=1);

require_once __DIR__ . '/../entities/Observatory.php';
require_once __DIR__ . '/../connection.php';

class ObservatoryModel
{
    private $conn;
    private $table = "observatories";

    public function __construct()
    {
        $database = new Connection();
        $this->conn = $database->getConnection();
    }

    public function getConnection() {
        return $this->conn;
    }

    // Lấy tất cả đài thiên văn
    public function getAll(): array
    {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $observatories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $observatories[] = Observatory::fromArray($row);
        }
        return $observatories;
    }

    // Lấy một đài thiên văn theo ID
    public function getById(int $id): ?Observatory
    {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? Observatory::fromArray($row) : null;
    }

    // Thêm đài thiên văn mới
    public function create(Observatory $observatory): ?int
    {
        $query = "INSERT INTO $this->table (name, location, description, image_url) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute([
            $this->sanitize($observatory->getName()),
            $this->sanitize($observatory->getLocation()),
            $this->sanitize($observatory->getDescription()),
            $this->sanitize($observatory->getImageUrl())
        ]);

        return (int)$this->conn->lastInsertId();
    }

    // Cập nhật đài thiên văn
    public function update(Observatory $observatory): bool
    {
        $query = "UPDATE $this->table 
                  SET name = ?, location = ?, description = ?, image_url = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->sanitize($observatory->getName()),
            $this->sanitize($observatory->getLocation()),
            $this->sanitize($observatory->getDescription()),
            $this->sanitize($observatory->getImageUrl()),
            $observatory->getId()
        ]);
    }

    // Xóa đài thiên văn
    public function delete(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Hàm sanitize dữ liệu
    private function sanitize(?string $input): ?string
    {
        return $input !== null ? htmlspecialchars(strip_tags($input)) : null;
    }

    // Get total number of observatories
    public function getTotalCount(): int {
        $query = "SELECT COUNT(*) as total FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get paginated observatories
    public function getPaginatedObservatories(int $page = 1, int $perPage = 5): array
    {
        try {
            // Ensure valid page number
            $page = max(1, $page);
            
            // Calculate offset
            $offset = ($page - 1) * $perPage;

            // Get total number of observatories
            $total = $this->getTotalCount();
            
            // Debug log
            error_log("Getting paginated observatories - Page: $page, Per page: $perPage, Total: $total");

            // Get paginated observatories
            $query = "SELECT * FROM $this->table ORDER BY id DESC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            $observatories = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $observatories[] = Observatory::fromArray($row);
            }

            // Calculate total pages
            $totalPages = max(1, ceil($total / $perPage));
            
            // Debug log
            error_log("Found " . count($observatories) . " observatories, Total pages: $totalPages");

            return [
                'observatories' => $observatories,
                'total' => $total,
                'total_pages' => $totalPages,
                'current_page' => $page
            ];
        } catch (Exception $e) {
            error_log("Error in getPaginatedObservatories: " . $e->getMessage());
            throw $e;
        }
    }
}
