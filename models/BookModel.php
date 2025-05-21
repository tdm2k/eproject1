<?php
require_once '../connection.php';
require_once '../entities/Book.php';

class BookModel
{
    private $conn;
    private $table = "books";

    public function __construct()
    {
        $database = new Connection();
        $this->conn = $database->getConnection();
    }

    // Get all books
    public function getAllBooks(): array
    {
        $query = "SELECT b.*, GROUP_CONCAT(c.name) as category_names 
                  FROM $this->table b 
                  LEFT JOIN book_categories bc ON b.id = bc.book_id 
                  LEFT JOIN categories c ON bc.category_id = c.id 
                  GROUP BY b.id 
                  ORDER BY b.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Convert category names string to array
            if (!empty($row['category_names'])) {
                $categoryNames = explode(',', $row['category_names']);
                $row['categories'] = array_map(function($name) {
                    return ['name' => $name];
                }, $categoryNames);
            } else {
                $row['categories'] = [];
            }
            unset($row['category_names']);
            
            $books[] = Book::fromArray($row);
        }
        return $books;
    }

    // Get book by ID
    public function getBookById(int $id): ?Book
    {
        $query = "SELECT b.*, GROUP_CONCAT(c.name) as category_names 
                  FROM $this->table b 
                  LEFT JOIN book_categories bc ON b.id = bc.book_id 
                  LEFT JOIN categories c ON bc.category_id = c.id 
                  WHERE b.id = ? 
                  GROUP BY b.id 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Convert category names string to array
            if (!empty($row['category_names'])) {
                $categoryNames = explode(',', $row['category_names']);
                $row['categories'] = array_map(function($name) {
                    return ['name' => $name];
                }, $categoryNames);
            } else {
                $row['categories'] = [];
            }
            unset($row['category_names']);
            
            return Book::fromArray($row);
        }
        return null;
    }

    // Add new book
    public function addBook(array $data): bool
    {
        $query = "INSERT INTO $this->table (
            title, image_url, author, publisher, publish_year, description, buy_link
        ) VALUES (
            :title, :image_url, :author, :publisher, :publish_year, :description, :buy_link
        )";
        
        $stmt = $this->conn->prepare($query);
        
        $params = [
            ':title' => $this->sanitize($data['title'] ?? null),
            ':image_url' => $this->sanitize($data['image_url'] ?? null),
            ':author' => $this->sanitize($data['author'] ?? null),
            ':publisher' => $this->sanitize($data['publisher'] ?? null),
            ':publish_year' => isset($data['publish_year']) ? (int)$data['publish_year'] : null,
            ':description' => $this->sanitize($data['description'] ?? null),
            ':buy_link' => $this->sanitize($data['buy_link'] ?? null)
        ];

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $success = $stmt->execute();
        
        if ($success && !empty($data['categories'])) {
            $bookId = $this->conn->lastInsertId();
            $this->updateBookCategories($bookId, $data['categories']);
        }

        return $success;
    }

    // Update book
    public function updateBook(int $id, array $data): bool
    {
        $query = "UPDATE $this->table 
                  SET title = :title, 
                      image_url = :image_url, 
                      author = :author, 
                      publisher = :publisher, 
                      publish_year = :publish_year, 
                      description = :description, 
                      buy_link = :buy_link 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $params = [
            ':id' => $id,
            ':title' => $this->sanitize($data['title'] ?? null),
            ':image_url' => $this->sanitize($data['image_url'] ?? null),
            ':author' => $this->sanitize($data['author'] ?? null),
            ':publisher' => $this->sanitize($data['publisher'] ?? null),
            ':publish_year' => isset($data['publish_year']) ? (int)$data['publish_year'] : null,
            ':description' => $this->sanitize($data['description'] ?? null),
            ':buy_link' => $this->sanitize($data['buy_link'] ?? null)
        ];

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $success = $stmt->execute();
        
        if ($success && isset($data['categories'])) {
            $this->updateBookCategories($id, $data['categories']);
        }

        return $success;
    }

    // Delete book
    public function deleteBook(int $id): bool
    {
        // First delete book categories
        $query = "DELETE FROM book_categories WHERE book_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Then delete the book
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Helper method to update book categories
    private function updateBookCategories(int $bookId, array $categoryIds): void
    {
        // First delete existing categories
        $query = "DELETE FROM book_categories WHERE book_id = :book_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        // Then insert new categories
        if (!empty($categoryIds)) {
            $query = "INSERT INTO book_categories (book_id, category_id) VALUES (:book_id, :category_id)";
            $stmt = $this->conn->prepare($query);
            
            foreach ($categoryIds as $categoryId) {
                $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
                $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }

    // Helper method to sanitize input
    private function sanitize($input)
    {
        if (is_string($input)) {
            return htmlspecialchars(strip_tags($input));
        }
        return $input;
    }

    // Get books by category
    public function getBooksByCategory(int $categoryId): array
    {
        $query = "SELECT b.*, GROUP_CONCAT(c.name) as category_names 
                  FROM $this->table b 
                  INNER JOIN book_categories bc ON b.id = bc.book_id 
                  INNER JOIN categories c ON bc.category_id = c.id 
                  WHERE bc.category_id = :category_id 
                  GROUP BY b.id 
                  ORDER BY b.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        
        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Convert category names string to array
            if (!empty($row['category_names'])) {
                $categoryNames = explode(',', $row['category_names']);
                $row['categories'] = array_map(function($name) {
                    return ['name' => $name];
                }, $categoryNames);
            } else {
                $row['categories'] = [];
            }
            unset($row['category_names']);
            
            $books[] = Book::fromArray($row);
        }
        return $books;
    }

    // Get all categories
    public function getAllCategories(): array
    {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}