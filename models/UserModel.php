<?php
require_once '../connection.php';

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Create User
    public function createUser(User $user): bool
    {
        $sql = "INSERT INTO users (username, password_hash, email, fullname, phone, role, dob, gender)
                VALUES (:username, :password_hash, :email, :fullname, :phone, :role, :dob, :gender)";

        $stmt = $this->conn->getConnection()->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':username', $user->getUsername());
        $stmt->bindParam(':password_hash', $user->getPasswordHash());
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':fullname', $user->getFullname());
        $stmt->bindParam(':phone', $user->getPhone());
        $stmt->bindParam(':role', $user->getRole());
        $stmt->bindParam(':dob', $user->getDob()->format('Y-m-d'));
        $stmt->bindParam(':gender', $user->getGender());

        return $stmt->execute();
    }

    // Update User
    public function updateUser(User $user): bool
    {
        $sql = "UPDATE users SET 
                username = :username, 
                password_hash = :password_hash, 
                email = :email, 
                fullname = :fullname, 
                phone = :phone, 
                role = :role, 
                dob = :dob, 
                gender = :gender, 
                WHERE id = :id";

        $stmt = $this->conn->getConnection()->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $user->getId());
        $stmt->bindParam(':username', $user->getUsername());
        $stmt->bindParam(':password_hash', $user->getPasswordHash());
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':fullname', $user->getFullname());
        $stmt->bindParam(':phone', $user->getPhone());
        $stmt->bindParam(':role', $user->getRole());
        $stmt->bindParam(':dob', $user->getDob()->format('Y-m-d'));
        $stmt->bindParam(':gender', $user->getGender());

        return $stmt->execute();
    }

    // Delete User
    public function deleteUser(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Find User by ID
    public function findUserById(int $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? User::fromArray($data) : null;
    }

    // Get all Users
    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM users";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($data as $userData) {
            $users[] = User::fromArray($userData);
        }

        return $users;
    }

    // Find User by Username
    public function findUserByUsername(string $username): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1"; // Thêm LIMIT 1 cho chắc chắn

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? User::fromArray($data) : null;
    }

    // Find User by Email
    public function findUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? User::fromArray($data) : null;
    }

    // Find User by Username or Email (FOR LOGIN)
    public function findUserByIdentifier(string $identifier): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :identifier OR email = :identifier LIMIT 1";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? User::fromArray($data) : null;
    }
}
