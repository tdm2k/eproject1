<?php
require_once __DIR__ . '/../connection.php';

class ArticleModel {
  private $conn;

  public function __construct() {
    $db = new Connection();         // Tạo một đối tượng Connection
    $this->conn = $db->getConnection(); // Lấy đối tượng PDO từ phương thức getConnection()
  }

  public function getAllArticles() {
    $sql = "SELECT * FROM articles ORDER BY id DESC";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getArticleById($id) {
    $sql = "SELECT * FROM articles WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function addArticle($data) {
    $sql = "INSERT INTO articles (title, content) VALUES (?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$data['title'], $data['content']]);
  }

  public function updateArticle($data) {
    $sql = "UPDATE articles SET title = ?, content = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$data['title'], $data['content'], $data['id']]);
  }

  public function deleteArticle($id) {
    $sql = "DELETE FROM articles WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
  }
}
