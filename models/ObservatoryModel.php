<?php
require_once '../connection.php';

// Interface cho observer
interface Observer {
    public function update($event, $data = null);
}

class CategoryObservable
{
    private $conn;
    private $observers = [];

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Đăng ký observer
    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    // Hủy đăng ký observer
    public function detach(Observer $observer)
    {
        foreach ($this->observers as $key => $obs) {
            if ($obs === $observer) {
                unset($this->observers[$key]);
            }
        }
        // reset lại mảng chỉ số
        $this->observers = array_values($this->observers);
    }

    // Thông báo observer khi có sự kiện
    private function notify($event, $data = null)
    {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }

    // Lấy tất cả category
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($data as $categoryData) {
            $categories[] = Category::fromArray($categoryData);
        }

        return $categories;
    }

    // Thêm category
    public function addCategory($name): bool
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);

        $result = $stmt->execute();
        if ($result) {
            // Thông báo observer về sự kiện thêm category
            $this->notify('category_added', ['name' => $name]);
        }
        return $result;
    }

    // Cập nhật category
    public function updateCategory($id, $name): bool
    {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);

        $result = $stmt->execute();
        if ($result) {
            $this->notify('category_updated', ['id' => $id, 'name' => $name]);
        }
        return $result;
    }

    // Xóa category
    public function deleteCategory($id): bool
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);

        $result = $stmt->execute();
        if ($result) {
            $this->notify('category_deleted', ['id' => $id]);
        }
        return $result;
    }
}
