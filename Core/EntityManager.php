<?php

declare(strict_types = 1);
class EntityManager {
    private ?mysqli $connection;

    private function __construct() {
        $this->connection = new mysqli(
            $_ENV["DB_HOST"],
            $_ENV["DB_USER"],
            $_ENV["DB_PASSWORD"],
            $_ENV["DB_NAME"]
        );

        if ($this->connection->connect_error) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    public static function getInstance(): EntityManager {
        if (!isset($instance)) {
            $instance = new EntityManager();
        }

        return $instance;
    }

    public function getConnection(): mysqli {
        return $this->connection;
    }

    public function closeConnection(): void {
        $this->connection?->close();
    }
}