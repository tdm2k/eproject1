<?php
require_once '../connection.php';

class AdminDashboardModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    //Get users count
    public function getUserCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE role = 'customer'";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    //get planets count
    public function getPlanetCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM planets";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    //get constellations count
    public function getConstellationCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM constellations";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    //get comets count
    public function getCometCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM comets";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    //get articles count
    public function getArticleCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM articles";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    //get videos count
    public function getVideoCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM videos";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    //get books count
    public function getBookCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM books";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    //get observatories count
    public function getObservatoryCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM observatories";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
