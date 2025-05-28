<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Core/EntityManager.php";

require_once __DIR__ . "/../Model/BodiesList.php";

class BodiesListRepository extends EntityRepository {
    private mysqli $connection;

    public function __construct() {
        $this->connection = EntityManager::getInstance()->getConnection();
    }

    public function create(BodiesList $bodiesList): ?BodiesList {
        $result = $this->connection->execute_query(
            "INSERT INTO `bodies_lists` (
                `latitude`, `longitude`, `date`, `time`, `bodies`
            ) VALUES (?, ?, ?, ?, ?)",
            [
                $bodiesList->getLatitude(), $bodiesList->getLongitude(),
                $bodiesList->getDate(), $bodiesList->getTime(),
                $bodiesList->getBodies()
            ]
        );

        if (!$result) {
            return null;
        }

        $id = $this->connection->insert_id;
        $bodiesList->setId($id);

        return $bodiesList;
    }

    public function read(int $id): ?Entity {
        $result = $this->connection->execute_query(
            "SELECT * FROM bodies_lists WHERE id = ?",
            [$id]
        )->fetch_assoc();

        if (!$result) {
            return null;
        }

        $bodiesList = new BodiesList($result['id']);

        $bodiesList->setLatitude($result['latitude']);
        $bodiesList->setLongitude($result['longitude']);
        $bodiesList->setDate($result['date']);
        $bodiesList->setTime($result['time']);

        $bodies = json_decode($result['bodies'], true);
        $bodiesList->setBodies($bodies);

        return $bodiesList;
    }

    public function update(Entity $entity): void {
        if (!$entity instanceof BodiesList) {
            throw new InvalidArgumentException("Expected BodiesList instance");
        }

        $this->connection->execute_query(
            "UPDATE bodies_lists 
             SET latitude = ?, longitude = ?, date = ?, time = ?, bodies = ? 
             WHERE id = ?",
            [
                $entity->getLatitude(),
                $entity->getLongitude(),
                $entity->getDate(),
                $entity->getTime(),
                json_encode($entity->getBodies()),
                $entity->getId()
            ]
        );
    }

    public function delete(Entity $entity): void {
        if (!$entity instanceof BodiesList) {
            throw new InvalidArgumentException("Expected BodiesList instance");
        }

        $this->connection->execute_query(
            "DELETE FROM bodies_lists WHERE id = ?",
            [$entity->getId()]
        );
    }

    public function find(int $id): Entity {
        return $this->read($id);
    }

    public function findByCoordinatesAndDateTime(
        float $latitude, float $longitude,
        DateTime $date, DateTime $time): ?BodiesList {
        $result = $this->connection->execute_query(
            "SELECT * FROM bodies_lists 
             WHERE latitude = ? 
             AND longitude = ? 
             AND date = ? 
             AND time = ? 
             LIMIT 1",
            [$latitude, $longitude, $date, $time]
        )->fetch_assoc();

        if (!$result) {
            return null;
        }

        $bodiesList = new BodiesList($result['id']);
        $bodiesList->setLatitude($result['latitude']);
        $bodiesList->setLongitude($result['longitude']);
        $bodiesList->setDate($result['date']);
        $bodiesList->setTime($result['time']);

        $bodies = json_decode($result['bodies'], true);
        $bodiesList->setBodies($bodies);

        return $bodiesList;
    }
}