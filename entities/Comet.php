<?php

declare(strict_types=1);

class Comet
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $features = null;
    private ?string $last_observed = null;
    private ?float $orbital_period_years = null;
    private ?string $description = null;
    private ?string $image = null;
    private ?int $category_id = null;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $features = null,
        ?string $last_observed = null,
        ?float $orbital_period_years = null,
        ?string $description = null,
        ?string $image = null,
        ?int $category_id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->features = $features;
        $this->last_observed = $last_observed;
        $this->orbital_period_years = $orbital_period_years;
        $this->description = $description;
        $this->image = $image;
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
    public function getFeatures(): ?string
    {
        return $this->features;
    }
    public function getLastObserved(): ?string
    {
        return $this->last_observed;
    }
    public function getOrbitalPeriodYears(): ?float
    {
        return $this->orbital_period_years;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    // --- Setters ---
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    public function setFeatures(?string $features): void
    {
        $this->features = $features;
    }
    public function setLastObserved(?string $last_observed): void
    {
        $this->last_observed = $last_observed;
    }
    public function setOrbitalPeriodYears(?float $orbital_period_years): void
    {
        $this->orbital_period_years = $orbital_period_years;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function setCategoryId(?int $category_id): void
    {
        $this->category_id = $category_id;
    }
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    // Phương thức load từ mảng
    public static function fromArray(array $data): self
    {
        $obj = new self(
            $data['id'] ?? null,
            $data['name'] ?? null,
            $data['features'] ?? null,
            $data['last_observed'] ?? null,
            isset($data['orbital_period_years']) ? (float) $data['orbital_period_years'] : null,
            $data['description'] ?? null,
            $data['image'] ?? null,
            $data['category_id'] ?? null
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
