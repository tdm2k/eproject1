<?php

declare(strict_types=1);

class Book
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $author = null;
    private ?string $publisher = null;
    private ?int $publish_year = null;
    private ?string $description = null;
    private ?string $buy_link = null;
    private array $categories = [];

    public function __construct(
        ?string $title = null,
        ?string $author = null,
        ?string $publisher = null,
        ?int $publish_year = null,
        ?string $description = null,
        ?string $buy_link = null,
        array $categories = []
    ) {
        $this->title = $title;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->publish_year = $publish_year;
        $this->description = $description;
        $this->buy_link = $buy_link;
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
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    public function getPublisher(): ?string
    {
        return $this->publisher;
    }
    public function getPublishYear(): ?int
    {
        return $this->publish_year;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getBuyLink(): ?string
    {
        return $this->buy_link;
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
    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }
    public function setPublisher(?string $publisher): void
    {
        $this->publisher = $publisher;
    }
    public function setPublishYear(?int $publish_year): void
    {
        $this->publish_year = $publish_year;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function setBuyLink(?string $buy_link): void
    {
        $this->buy_link = $buy_link;
    }
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    // Phương thức load từ mảng
    public static function fromArray(array $data): self
    {
        $obj = new self(
            $data['id'] ?? null,
            $data['title'] ?? null,
            $data['author'] ?? null,
            $data['publisher'] ?? null,
            $data['publish_year'] ?? null,
            $data['description'] ?? null,
            $data['buy_link'] ?? null,
            $data['categories'] ?? []
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
