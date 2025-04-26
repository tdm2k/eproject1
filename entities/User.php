<?php

declare(strict_types=1);

class User
{
    private ?int $id = null;
    private ?string $username = null;
    private string $password_hash;
    private ?string $email = null;
    private ?string $fullname = null;
    private ?string $phone = null;
    private ?string $role = null;
    private ?DateTime $dob = null;
    private ?int $gender = null; // Thay bool thành int cho gender (0: nam, 1: nữ)

    // Constructor
    public function __construct(
        string $password_hash,
        ?string $username = null,
        ?string $email = null,
        ?string $fullname = null,
        ?string $phone = null,
        ?string $role = null,
        ?DateTime $dob = null,
        ?int $gender = null // Sử dụng int cho gender
    ) {
        $this->password_hash = $password_hash;
        $this->username = $username;
        $this->email = $email;
        $this->fullname = $fullname;
        $this->phone = $phone;
        $this->role = $role;
        $this->dob = $dob;
        $this->gender = $gender;
    }

    // --- Getters ---
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getDob(): ?DateTime
    {
        return $this->dob;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    // --- Setters ---
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function setPasswordHash(string $password_hash): void
    {
        $this->password_hash = $password_hash;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setFullname(?string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    public function setDob(?DateTime $dob): void
    {
        $this->dob = $dob;
    }

    public function setGender(?int $gender): void
    {
        $this->gender = $gender;
    }

    // Phương thức để load dữ liệu từ mảng
    public static function fromArray(array $data): self
    {
        $obj = new self(
            $data['password_hash'], // bắt buộc
            $data['username'] ?? null,
            $data['email'] ?? null,
            $data['fullname'] ?? null,
            $data['phone'] ?? null,
            $data['role'] ?? null,
            isset($data['dob']) ? new DateTime($data['dob']) : null,
            isset($data['gender']) ? (int) $data['gender'] : null
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
