<?php
require_once '../connection.php';

class PasswordResetModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Create Password Reset Token
    public function createPasswordResetToken($email, $token, $expiredAt): bool
    {
        $sql = "INSERT INTO password_resets (email, token, expired_at) VALUES (:email, :token, :expired_at)";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expired_at', $expiredAt);

        return $stmt->execute();
    }

    // Get Password Reset Token By Email
    public function findPasswordResetByEmail($email): ?string
    {
        $sql = "SELECT token FROM password_resets WHERE email = :email LIMIT 1";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $data['token'] : null;
    }

    // Get Password Reset Token By Token
    public function findPasswordResetByToken($token): ?array
    {
        $sql = "SELECT email, expired_at FROM password_resets WHERE token = :token LIMIT 1";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete Password Reset Token
    public function deletePasswordResetToken($email): bool
    {
        $sql = "DELETE FROM password_resets WHERE email = :email";
        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }

    // Delete Expired Password Reset Tokens
    public function deleteExpiredTokens(): bool
    {
        $sql = "DELETE FROM password_resets WHERE expired_at < NOW()";
        $stmt = $this->conn->getConnection()->prepare($sql);

        return $stmt->execute();
    }
}
