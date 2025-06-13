<?php
require_once __DIR__ . '/../connection.php';

class ArticleModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->getConnection();
    }

    public function getAllArticlesPaginated($limit, $offset) {
        $stmt = $this->conn->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalArticles() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM articles");
        return $stmt->fetchColumn();
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

    public function updateArticle($data) {
        $stmt = $this->conn->prepare("UPDATE articles SET title = ?, content = ?, image_url = ? WHERE id = ?");
        $stmt->execute([$data['title'], $data['content'], $data['image_url'], $data['id']]);
    }

    public function deleteArticle($id) {
        $stmt = $this->conn->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->execute([$id]);
    }
}
