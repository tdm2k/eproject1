<?php

declare(strict_types=1);

require_once __DIR__ . '/../entities/Video.php';
require_once __DIR__ . '/../connection.php';

class VideoModel
{
    private $conn;
    private $table = "videos";

    public function __construct()
    {
        $database = new Connection();
        $this->conn = $database->getConnection();
    }

    public function getConnection()
    {
        return $this->conn;
    }

    // Lấy tất cả video
    public function getAll(): array
    {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $videos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $videos[] = Video::fromArray($row);
        }
        return $videos;
    }

    // Lấy một video theo ID
    public function getById(int $id): ?Video
    {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? Video::fromArray($row) : null;
    }

    // Thêm video mới
    public function create(Video $video): ?int
    {
        $query = "INSERT INTO $this->table (title, url, description, thumbnail_url) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            $this->sanitize($video->getTitle()),
            $this->sanitize($video->getUrl()),
            $this->sanitize($video->getDescription()),
            $this->sanitize($video->getThumbnailUrl())
        ]);

        return (int)$this->conn->lastInsertId();
    }

    // Cập nhật video
    public function update(Video $video): bool
    {
        $query = "UPDATE $this->table 
                  SET title = ?, url = ?, description = ?, thumbnail_url = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $this->sanitize($video->getTitle()),
            $this->sanitize($video->getUrl()),
            $this->sanitize($video->getDescription()),
            $this->sanitize($video->getThumbnailUrl()),
            $video->getId()
        ]);
    }

    // Xóa video
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

    // Get total number of videos
    public function getTotalCount(): int
    {
        $query = "SELECT COUNT(*) as total FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get paginated videos
    public function getPaginatedVideos(int $page = 1, int $perPage = 5): array
    {
        try {
            $page = max(1, $page);
            $offset = ($page - 1) * $perPage;
            $total = $this->getTotalCount();

            error_log("Getting paginated videos - Page: $page, Per page: $perPage, Total: $total");

            $query = "SELECT * FROM $this->table ORDER BY id DESC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);
            $stmt->execute();

            $videos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $videos[] = Video::fromArray($row);
            }

            $totalPages = max(1, ceil($total / $perPage));

            error_log("Found " . count($videos) . " videos, Total pages: $totalPages");

            return [
                'videos' => $videos,
                'total' => $total,
                'total_pages' => $totalPages,
                'current_page' => $page
            ];
        } catch (Exception $e) {
            error_log("Error in getPaginatedVideos: " . $e->getMessage());
            throw $e;
        }
    }
}
