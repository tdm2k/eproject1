<?php
require_once '../connection.php';

class CometModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    //Create comet
    public function createComet(Comet $comet): bool
    {
        $sql = "INSERT INTO comets (name, features, last_observed, orbital_period_years, description, image, category_id)
            VALUES (:name, :features, :last_observed, :orbital_period_years, :description, :image, :category_id)";

        $stmt = $this->conn->getConnection()->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $comet->getName());
        $stmt->bindParam(':features', $comet->getFeatures());
        $stmt->bindParam(':last_observed', $comet->getLastObserved());
        $stmt->bindParam(':orbital_period_years', $comet->getOrbitalPeriodYears());
        $stmt->bindParam(':description', $comet->getDescription());
        $stmt->bindParam(':image', $comet->getImage());
        $stmt->bindParam(':category_id', $comet->getCategoryId());

        return $stmt->execute();
    }

    public function updateComet(Comet $comet): bool
    {
        $sql = "UPDATE comets SET
                name = :name,
                features = :features,
                last_observed = :last_observed,
                orbital_period_years = :orbital_period_years,
                description = :description,
                image = :image,
                category_id = :category_id
            WHERE id = :id";

        $stmt = $this->conn->getConnection()->prepare($sql);

        $id = $comet->getId();
        $name = $comet->getName();
        $features = $comet->getFeatures();
        $lastObserved = $comet->getLastObserved();
        $orbitalPeriodYears = $comet->getOrbitalPeriodYears();
        $description = $comet->getDescription();
        $image = $comet->getImage();
        $categoryId = $comet->getCategoryId();

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':features', $features);
        $stmt->bindParam(':last_observed', $lastObserved);
        $stmt->bindParam(':orbital_period_years', $orbitalPeriodYears);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteComet(int $id): bool
    {
        $sql = "DELETE FROM comets WHERE id = :id";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAllComets(): array
    {
        $sql = "SELECT * FROM comets";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $comets = [];

        foreach ($data as $cometData) {
            $comets[] = Comet::fromArray($cometData);
        }

        return $comets;
    }

    public function getCometById(int $id): ?Comet
    {
        $sql = "SELECT * FROM comets WHERE id = :id";

        $stmt = $this->conn->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? Comet::fromArray($data) : null;
    }
}
