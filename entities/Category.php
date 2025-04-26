<?php

declare(strict_types=1);

class Category
{
    private ?int $id = null;
    private ?string $name = null;

    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    // --- Getters ---
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
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
        $category = new self($data['name'] ?? null);
        $category->id = $data['id'] ?? null;
        return $category;
    }
}
