<?php

declare(strict_types=1);

class Article
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $content = null;
    private ?string $image_url = null;
    private ?DateTime $created_at = null;
    private array $categories = [];

    public function __construct(
        ?string $title = null,
        ?string $content = null,
        ?string $image_url = null,
        ?DateTime $created_at = null,
        array $categories = []
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->image_url = $image_url;
        $this->created_at = $created_at ?? new DateTime();
        $this->categories = $categories;
    }

    // --- Getters ---
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }
    public function getCategories(): array
    {
        return $this->categories;
    }

    // --- Setters ---
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }
    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    // Phương thức load từ mảng
    public static function fromArray(array $data): self
    {
        $obj = new self(
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['image_url'] ?? null,
            isset($data['created_at']) ? new DateTime($data['created_at']) : null,
            $data['categories'] ?? []
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
