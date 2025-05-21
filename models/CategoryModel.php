<?php
require_once '../connection.php';

class CategoryModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Get all categories
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

    // Get category by ID
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return Category::fromArray($data);
        }
        return null;
    }

    // Add category
    public function addCategory($name): bool
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    // Update category
    public function updateCategory($id, $name): bool
    {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    // Delete category
    public function deleteCategory($id): bool
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}