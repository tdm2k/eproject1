<?php

declare(strict_types=1);

class Constellation
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?string $notable_stars = null;
    private ?int $category_id = null;

    public function __construct(
        ?string $name = null,
        ?string $description = null,
        ?string $notable_stars = null,
        ?int $category_id = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->notable_stars = $notable_stars;
        $this->category_id = $category_id;
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
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getNotableStars(): ?string
    {
        return $this->notable_stars;
    }
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    // --- Setters ---
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function setNotableStars(?string $notable_stars): void
    {
        $this->notable_stars = $notable_stars;
    }
    public function setCategoryId(?int $category_id): void
    {
        $this->category_id = $category_id;
    }

    // Phương thức load từ mảng
    public static function fromArray(array $data): self
    {
        $obj = new self(
            $data['name'] ?? null,
            $data['description'] ?? null,
            $data['notable_stars'] ?? null,
            $data['category_id'] ?? null
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
