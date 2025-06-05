<?php
require_once __DIR__ . '/../connection.php';

class ArticleModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->getConnection();

    }

    public function getAllArticles() {
        $stmt = $this->conn->prepare("SELECT * FROM articles ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addArticle($data) {
        $sql = "INSERT INTO articles (title, content, image_url) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['title'],
            $data['content'],
            $data['image_url'] ?? null
        ]);
    }

    public function createArticle($data) {
    $stmt = $this->conn->prepare("INSERT INTO articles (title, content, image_url, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$data['title'], $data['content'], $data['image_url']]);
    }

    public function updateArticle($data) {
    $stmt = $this->conn->prepare("UPDATE articles SET title = ?, content = ?, image_url = ? WHERE id = ?");
    $stmt->execute([$data['title'], $data['content'], $data['image_url'], $data['id']]);
    }

    public function deleteArticle($id) {
        $stmt = $this->conn->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->execute([$id]);
    }
}
