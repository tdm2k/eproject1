<?php

declare(strict_types=1);

class Video
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $url = null;
    private ?string $description = null;
    private ?string $thumbnail_url = null;
    private ?DateTime $uploaded_at = null;
    private array $categories = [];

    public function __construct(
        ?string $title = null,
        ?string $url = null,
        ?string $description = null,
        ?string $thumbnail_url = null,
        ?DateTime $uploaded_at = null,
        array $categories = []
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->thumbnail_url = $thumbnail_url;
        $this->uploaded_at = $uploaded_at ?? new DateTime();
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
    public function getUrl(): ?string
    {
        return $this->url;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnail_url;
    }
    public function getUploadedAt(): ?DateTime
    {
        return $this->uploaded_at;
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
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function setThumbnailUrl(?string $thumbnail_url): void
    {
        $this->thumbnail_url = $thumbnail_url;
    }
    public function setUploadedAt(?DateTime $uploaded_at): void
    {
        $this->uploaded_at = $uploaded_at;
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
            $data['url'] ?? null,
            $data['description'] ?? null,
            $data['thumbnail_url'] ?? null,
            isset($data['uploaded_at']) ? new DateTime($data['uploaded_at']) : null,
            $data['categories'] ?? []
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
