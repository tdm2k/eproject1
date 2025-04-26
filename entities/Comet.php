<?php

declare(strict_types=1);

class Comet
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $features = null;
    private ?DateTime $last_observed = null;
    private ?float $orbital_period_years = null;
    private ?string $description = null;
    private ?int $category_id = null;

    public function __construct(
        ?string $name = null,
        ?string $features = null,
        ?DateTime $last_observed = null,
        ?float $orbital_period_years = null,
        ?string $description = null,
        ?int $category_id = null
    ) {
        $this->name = $name;
        $this->features = $features;
        $this->last_observed = $last_observed;
        $this->orbital_period_years = $orbital_period_years;
        $this->description = $description;
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
    public function getLastObserved(): ?DateTime
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

    // --- Setters ---
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    public function setFeatures(?string $features): void
    {
        $this->features = $features;
    }
    public function setLastObserved(?DateTime $last_observed): void
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

    // Phương thức load từ mảng
    public static function fromArray(array $data): self
    {
        $obj = new self(
            $data['name'] ?? null,
            $data['features'] ?? null,
            isset($data['last_observed']) ? new DateTime($data['last_observed']) : null,
            isset($data['orbital_period_years']) ? (float) $data['orbital_period_years'] : null,
            $data['description'] ?? null,
            $data['category_id'] ?? null
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
