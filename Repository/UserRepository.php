<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Core/EntityManager.php";

require_once __DIR__ . "/../Model/User.php";

require_once __DIR__ . "/EntityRepository.php";

class UserRepository extends EntityRepository {
    private mysqli $connection;

    public function __construct() {
        $this->connection = EntityManager::getInstance()->getConnection();
    }

    public function create(
        string $firstName, string $lastName,
        string $email, string $password,
        string $salt, string $token,
        bool $isVerified = false
    ): ?User {
        $result = $this->connection->execute_query(
            "INSERT INTO `users` (
                `first_name`, `last_name`, `email`, 
                `password`, `salt`, `token`, `is_verified`
            ) VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                $firstName, $lastName,
                $email, $password,
                $salt, $token,
                $isVerified ? 1 : 0
            ]
        );

        if (!$result) {
            return null;
        }

        $id = $this->connection->insert_id;

        $user = new User($id);

        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setSalt($salt);
        $user->setToken($token);
        $user->setIsVerified($isVerified);

        return $user;
    }

    public function read(int $id): ?User {
        $result = $this->connection->execute_query(
            "SELECT * FROM `users` WHERE `id` = ?",
            [$id]
        );

        $data = $result->fetch_assoc();
        $result->free();

        if (!$data) {
            return null;
        }

        $user = new User($id);

        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setSalt($data['salt']);
        $user->setToken($data['token']);
        $user->setIsVerified((bool)$data['is_verified']);

        if ($data['latitude'] !== null) {
            $user->setLatitude((float)$data['latitude']);
        }

        if ($data['longitude'] !== null) {
            $user->setLongitude((float)$data['longitude']);
        }

        if (!empty($data['last_selected_date'])) {
            $user->setLastSelectedDate($data['last_selected_date']);
        }

        if (!empty($data['last_selected_time'])) {
            $user->setLastSelectedTime($data['last_selected_time']);
        }

        return $user;
    }

    public function update(Entity $entity): void {
        if (!$entity instanceof User) {
            throw new InvalidArgumentException("Expected User instance");
        }

        $this->connection->execute_query(
            "UPDATE `users` SET
                `first_name` = ?, `last_name` = ?,
                `email` = ?, `password` = ?,
                `salt` = ?, `token` = ?,
                `is_verified` = ?, `latitude` = ?,
                `longitude` = ?,
                `last_selected_date` = ?, `last_selected_time` = ?
            WHERE `id` = ?",
            [
                $entity->getFirstName(),
                $entity->getLastName(),
                $entity->getEmail(),
                $entity->getPassword(),
                $entity->getSalt(),
                $entity->getToken(),
                $entity->getIsVerified() ? 1 : 0,
                $entity->getLatitude(),
                $entity->getLongitude(),
                $entity->getLastSelectedDate()->format('Y-m-d'),
                $entity->getLastSelectedTime()->format('H:i:s'),
                $entity->getId()
            ]
        );
    }

    public function delete(Entity $entity): void {
        if (!$entity instanceof User) {
            throw new InvalidArgumentException("Expected User instance");
        }

        $this->connection->execute_query(
            "DELETE FROM `users` WHERE `id` = ?",
            [$entity->getId()]
        );
    }
}