<?php

declare(strict_types=1);

class Video
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $url = null;
    private ?string $description = null;
    private ?string $thumbnail_url = null;

    public function __construct(
        ?string $title = null,
        ?string $url = null,
        ?string $description = null,
        ?string $thumbnail_url = null
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->thumbnail_url = $thumbnail_url;
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

    // Thêm phương thức để tránh lỗi undefined method
    public function getVideoUrl(): ?string
    {
        return $this->getUrl();
    }

    // --- NEW: Tự động lấy thumbnail từ URL YouTube nếu không có thumbnail ---
    public function getAutoThumbnail(): ?string
    {
        if (!$this->url) {
            return null;
        }

        // Bắt video ID từ YouTube URL
        preg_match('/(?:v=|\/)([0-9A-Za-z_-]{11})/', $this->url, $matches);
        $videoId = $matches[1] ?? null;

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        return null;
    }

    // --- Setters ---
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

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

    // --- Static Methods ---
    public static function fromArray(array $data): self
    {
        $video = new self(
            $data['title'] ?? null,
            $data['url'] ?? null,
            $data['description'] ?? null,
            $data['thumbnail_url'] ?? null
        );

        if (isset($data['id'])) {
            $video->setId((int)$data['id']);
        }

        return $video;
    }
}
