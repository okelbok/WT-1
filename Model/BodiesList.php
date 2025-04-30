<?php

declare(strict_types=1);

require_once 'Entity.php';

class BodiesList extends Entity {
    private int $id;
    private array $bodies;

    public function __construct(int $id) {
        $this->id = $id;
        $this->bodies = array(
            "Sun" => null, "Moon" => null,
            "Mercury" => null, "Venus" => null, "Earth" => null, "Mars" => null,
            "Jupiter" => null, "Saturn" => null, "Uranus" => null, "Neptune" => null);
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): BodiesList {
        $this->id = $id;
        return $this;
    }

    public function getBodies(): array {
        return $this->bodies;
    }

    public function setBodies(array $bodies): BodiesList {
        $this->bodies = $bodies;
        return $this;
    }
}