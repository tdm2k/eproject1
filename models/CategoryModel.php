<?php
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../entities/Category.php';

class CategoryModel
{
    private $conn;

    public function __construct()
    {
        $database = new Connection();
        $this->conn = $database->getConnection();
    }

    // Get all categories
    public function getAllCategories()
    {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $categories = [];
        foreach ($data as $categoryData) {
            $categories[] = new Category(
                $categoryData['id'],
                $categoryData['name']
            );
        }
        return $categories;
    }

    // Add category
    public function addCategory($name): bool
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    // Update category
    public function updateCategory($id, $name): bool
    {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    // Delete category
    public function deleteCategory($id): bool
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
