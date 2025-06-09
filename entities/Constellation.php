<?php
declare(strict_types=1);

class Constellation {
    private ?int $id = null;
    private ?string $name = null;
    private ?string $image = null;
    private ?string $description = null;
    private ?string $notable_stars = null;
    private ?int $category_id = null;
    private ?string $position = null;
    private ?string $legend = null;

    public function __construct(
        ?string $name = null,
        ?string $description = null,
        ?string $notable_stars = null,
        ?int $category_id = null,
        ?string $image = null,
        ?string $position = null,
        ?string $legend = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->notable_stars = $notable_stars;
        $this->category_id = $category_id;
        $this->image = $image;
        $this->position = $position;
        $this->legend = $legend;
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function getImage(): ?string { return $this->image; }
    public function getDescription(): ?string { return $this->description; }
    public function getNotableStars(): ?string { return $this->notable_stars; }
    public function getCategoryId(): ?int { return $this->category_id; }
    public function getPosition(): ?string { return $this->position; }
    public function getLegend(): ?string { return $this->legend; }

    public function setName(?string $name): void { $this->name = $name; }
    public function setImage(?string $image): void { $this->image = $image; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setNotableStars(?string $notable_stars): void { $this->notable_stars = $notable_stars; }
    public function setCategoryId(?int $category_id): void { $this->category_id = $category_id; }
    public function setPosition(?string $position): void { $this->position = $position; }
    public function setLegend(?string $legend): void { $this->legend = $legend; }

    public static function fromArray(array $data): self {
        $obj = new self(
            $data['name'] ?? null,
            $data['description'] ?? null,
            $data['notable_stars'] ?? null,
            isset($data['category_id']) ? (int)$data['category_id'] : null,
            $data['image'] ?? null,
            $data['position'] ?? null,
            $data['legend'] ?? null
        );
        $obj->id = isset($data['id']) ? (int)$data['id'] : null;
        return $obj;
    }
}
