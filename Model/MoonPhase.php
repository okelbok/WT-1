<?php

class MoonPhase extends Entity {
    private int $id;
    private string $name;
    private float $timestamp;

    function __construct(int $id) {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): MoonPhase {
        $this->id = $id;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): MoonPhase {
        $this->name = $name;
        return $this;
    }

    public function getTimestamp(): float {
        return $this->timestamp;
    }

    public function setTimestamp(float $timestamp): MoonPhase {
        $this->timestamp = $timestamp;
        return $this;
    }
}

