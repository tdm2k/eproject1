<?php

declare(strict_types=1);

class Observatory
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $location = null;
    private ?string $description = null;
    private ?string $image_url = null;

    public function __construct(
        ?string $name = null,
        ?string $location = null,
        ?string $description = null,
        ?string $image_url = null
    ) {
        $this->name = $name;
        $this->location = $location;
        $this->description = $description;
        $this->image_url = $image_url;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    // --- Setters ---
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }

    // --- Static Methods ---
    public static function fromArray(array $data): self
    {
        $observatory = new self(
            $data['name'] ?? null,
            $data['location'] ?? null,
            $data['description'] ?? null,
            $data['image_url'] ?? null
        );

        if (isset($data['id'])) {
            $observatory->setId((int)$data['id']);
        }

        return $observatory;
    }
}
