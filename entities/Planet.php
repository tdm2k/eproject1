<?php

declare(strict_types=1);

class Planet
{
    private ?int $id = null;
    private ?string $name = null;
    private ?DateTime $discovery_date = null;
    private ?string $atmosphere = null;
    private ?float $distance_from_earth_km = null;
    private ?string $description = null;
    private ?int $category_id = null;

    public function __construct(
        ?string $name = null,
        ?DateTime $discovery_date = null,
        ?string $atmosphere = null,
        ?float $distance_from_earth_km = null,
        ?string $description = null,
        ?int $category_id = null
    ) {
        $this->name = $name;
        $this->discovery_date = $discovery_date;
        $this->atmosphere = $atmosphere;
        $this->distance_from_earth_km = $distance_from_earth_km;
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
    public function getDiscoveryDate(): ?DateTime
    {
        return $this->discovery_date;
    }
    public function getAtmosphere(): ?string
    {
        return $this->atmosphere;
    }
    public function getDistanceFromEarthKm(): ?float
    {
        return $this->distance_from_earth_km;
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
    public function setDiscoveryDate(?DateTime $discovery_date): void
    {
        $this->discovery_date = $discovery_date;
    }
    public function setAtmosphere(?string $atmosphere): void
    {
        $this->atmosphere = $atmosphere;
    }
    public function setDistanceFromEarthKm(?float $distance_from_earth_km): void
    {
        $this->distance_from_earth_km = $distance_from_earth_km;
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
            isset($data['discovery_date']) ? new DateTime($data['discovery_date']) : null,
            $data['atmosphere'] ?? null,
            isset($data['distance_from_earth_km']) ? (float) $data['distance_from_earth_km'] : null,
            $data['description'] ?? null,
            $data['category_id'] ?? null
        );

        $obj->id = $data['id'] ?? null;
        return $obj;
    }
}
