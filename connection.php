<?php
class Connection
{
    private $host = "localhost:3307";
    private $username = "root";
    private $password = "12345678";
    private $dbname = "eproject1";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
