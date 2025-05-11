<?php

declare(strict_types=1);

class Planet
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $image = null;
    private ?string $description = null;
    private ?string $potential_for_life = null;
    private ?string $orbit_and_rotation = null;
    private ?bool $rings = null;
    private ?string $structure = null;
    private ?string $atmosphere = null;
    private ?string $name_sake = null;
    private ?string $size_and_distance = null;
    private ?string $moons = null;
    private ?string $formation = null;
    private ?string $surface = null;
    private ?string $magnetosphere = null;
    private ?int $category_id = null;
    private ?bool $is_deleted = null;
    public ?string $category_name = null; // Thêm thuộc tính để lưu category_name

    public function __construct(
        ?string $name = null,
        ?string $image = null,
        ?string $description = null,
        ?string $potential_for_life = null,
        ?string $orbit_and_rotation = null,
        ?bool $rings = null,
        ?string $structure = null,
        ?string $atmosphere = null,
        ?string $name_sake = null,
        ?string $size_and_distance = null,
        ?string $moons = null,
        ?string $formation = null,
        ?string $surface = null,
        ?string $magnetosphere = null,
        ?int $category_id = null,
        ?bool $is_deleted = null
    ) {
        $this->name = $name;
        $this->image = $image;
        $this->description = $description;
        $this->potential_for_life = $potential_for_life;
        $this->orbit_and_rotation = $orbit_and_rotation;
        $this->rings = $rings;
        $this->structure = $structure;
        $this->atmosphere = $atmosphere;
        $this->name_sake = $name_sake;
        $this->size_and_distance = $size_and_distance;
        $this->moons = $moons;
        $this->formation = $formation;
        $this->surface = $surface;
        $this->magnetosphere = $magnetosphere;
        $this->category_id = $category_id;
        $this->is_deleted = $is_deleted;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPotentialForLife(): ?string
    {
        return $this->potential_for_life;
    }

    public function getOrbitAndRotation(): ?string
    {
        return $this->orbit_and_rotation;
    }

    public function getRings(): ?bool
    {
        return $this->rings;
    }

    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function getAtmosphere(): ?string
    {
        return $this->atmosphere;
    }

    public function getNameSake(): ?string
    {
        return $this->name_sake;
    }

    public function getSizeAndDistance(): ?string
    {
        return $this->size_and_distance;
    }

    public function getMoons(): ?string
    {
        return $this->moons;
    }

    public function getFormation(): ?string
    {
        return $this->formation;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function getMagnetosphere(): ?string
    {
        return $this->magnetosphere;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
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

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setPotentialForLife(?string $potential_for_life): void
    {
        $this->potential_for_life = $potential_for_life;
    }

    public function setOrbitAndRotation(?string $orbit_and_rotation): void
    {
        $this->orbit_and_rotation = $orbit_and_rotation;
    }

    public function setRings(?bool $rings): void
    {
        $this->rings = $rings;
    }

    public function setStructure(?string $structure): void
    {
        $this->structure = $structure;
    }

    public function setAtmosphere(?string $atmosphere): void
    {
        $this->atmosphere = $atmosphere;
    }

    public function setNameSake(?string $name_sake): void
    {
        $this->name_sake = $name_sake;
    }

    public function setSizeAndDistance(?string $size_and_distance): void
    {
        $this->size_and_distance = $size_and_distance;
    }

    public function setMoons(?string $moons): void
    {
        $this->moons = $moons;
    }

    public function setFormation(?string $formation): void
    {
        $this->formation = $formation;
    }

    public function setSurface(?string $surface): void
    {
        $this->surface = $surface;
    }

    public function setMagnetosphere(?string $magnetosphere): void
    {
        $this->magnetosphere = $magnetosphere;
    }

    public function setCategoryId(?int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function setIsDeleted(?bool $is_deleted): void
    {
        $this->is_deleted = $is_deleted;
    }

    // Phương thức load từ mảng
    public static function fromArray(array $data): self
    {
        $obj = new self(
            $data['name'] ?? null,
            $data['image'] ?? null,
            $data['description'] ?? null,
            $data['potential_for_life'] ?? null,
            $data['orbit_and_rotation'] ?? null,
            isset($data['rings']) ? (bool)$data['rings'] : null, // Ép kiểu int sang bool
            $data['structure'] ?? null,
            $data['atmosphere'] ?? null,
            $data['name_sake'] ?? null,
            $data['size_and_distance'] ?? null,
            $data['moons'] ?? null,
            $data['formation'] ?? null,
            $data['surface'] ?? null,
            $data['magnetosphere'] ?? null,
            isset($data['category_id']) ? (int)$data['category_id'] : null,
            isset($data['is_deleted']) ? (bool)$data['is_deleted'] : null // Ép kiểu int sang bool
        );

        if (isset($data['id'])) {
            $obj->setId((int)$data['id']);
        }
        if (isset($data['category_name'])) {
            $obj->category_name = $data['category_name'];
        }

        return $obj;
    }
}