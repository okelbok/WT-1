<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Core/EntityManager.php";
require_once __DIR__ . "/../Model/MoonPhase.php";

class MoonPhaseRepository extends EntityRepository {
    private mysqli $connection;

    public function __construct() {
        $this->connection = EntityManager::getInstance()->getConnection();
    }

    public function create(MoonPhase $moonPhase): ?MoonPhase {
        $result = $this->connection->execute_query(
            "INSERT INTO moon_phases (latitude, longitude, date, image_url) VALUES (?, ?, ?, ?)",
            [
                $moonPhase->getLatitude(),
                $moonPhase->getLongitude(),
                $moonPhase->getDate()->format('Y-m-d'),
                $moonPhase->getImageUrl()
            ]
        );

        if (!$result) {
            return null;
        }

        $id = $this->connection->insert_id;
        $moonPhase->setId($id);

        return $moonPhase;
    }

    public function read(int $id): ?Entity {
        $result = $this->connection->execute_query(
            "SELECT * FROM moon_phases WHERE id = ?",
            [$id]
        )->fetch_assoc();

        if (!$result) {
            return null;
        }

        $moonPhase = new MoonPhase($result['id']);
        $moonPhase->setLatitude($result['latitude']);
        $moonPhase->setLongitude($result['longitude']);
        $moonPhase->setDate($result['date']);
        $moonPhase->setImageUrl($result['image_url']);

        return $moonPhase;
    }

    public function update(Entity $entity): void {
        if (!$entity instanceof MoonPhase) {
            throw new InvalidArgumentException("Expected MoonPhase instance");
        }

        $this->connection->execute_query(
            "UPDATE moon_phases SET latitude = ?, longitude = ?, date = ?, image_url = ? WHERE id = ?",
            [
                $entity->getLatitude(),
                $entity->getLongitude(),
                $entity->getDate()->format('Y-m-d'),
                $entity->getImageUrl(),
                $entity->getId()
            ]
        );
    }

    public function delete(Entity $entity): void {
        if (!$entity instanceof MoonPhase) {
            throw new InvalidArgumentException("Expected MoonPhase instance");
        }

        $this->connection->execute_query(
            "DELETE FROM moon_phases WHERE id = ?",
            [$entity->getId()]
        );
    }

    public function find(int $id): ?Entity {
        return $this->read($id);
    }

    public function findByCoordinatesAndDate(float $latitude, float $longitude, DateTime $date): ?MoonPhase {
        $result = $this->connection->execute_query(
            "SELECT * FROM moon_phases WHERE latitude = ? AND longitude = ? AND date = ? LIMIT 1",
            [
                $latitude,
                $longitude,
                $date->format('Y-m-d')
            ]
        )->fetch_assoc();

        if (!$result) {
            return null;
        }

        $moonPhase = new MoonPhase($result['id']);
        $moonPhase->setLatitude($result['latitude']);
        $moonPhase->setLongitude($result['longitude']);
        $moonPhase->setDate($result['date']);
        $moonPhase->setImageUrl($result['image_url']);

        return $moonPhase;
    }
}