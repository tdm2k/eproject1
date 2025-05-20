<?php

declare(strict_types=1);

class Category
{
    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    // --- Getters ---
    public function getId(): mixed
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }

    // --- Setters ---
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    // Phương thức load từ mảng
    public static function fromArray(array $data): self
    {
        $category = new self($data['id'] ?? null, $data['name'] ?? null);
        return $category;
    }
}
