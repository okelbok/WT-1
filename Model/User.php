<?php

class User extends Entity {
    private int $id;
    private array $coordinates = [];

    function __construct(int $id) {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): User {
        $this->id = $id;
        return $this;
    }

    public function getCoordinates(): array {
        return $this->coordinates;
    }

    public function setCoordinates(float $longitude, float $latitude): User {
        $this->coordinates['longitude'] = $longitude;
        $this->coordinates['latitude'] = $latitude;
        return $this;
    }
}