<?php

require_once __DIR__.'/../Model/Entity.php';

class User extends Entity {
    private int $id;
    private array $coordinates = [];
    private string $lastSelectedDate;
    private string $lastTimeActive;

    function __construct(int $id, array $coordinates, string $lastSelectedDate, string $lastTimeActive) {
        $this->id = $id;
        $this->coordinates = $coordinates;
        $this->lastSelectedDate = $lastSelectedDate;
        $this->lastTimeActive = $lastTimeActive;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): int {
        $this->id = $id;

        return $this->id;
    }

    public function getCoordinates(): array {
        return $this->coordinates;
    }

    public function setCoordinates(float $longitude, float $latitude): array {
        $this->coordinates['longitude'] = $longitude;
        $this->coordinates['latitude'] = $latitude;

        return $this->coordinates;
    }

    public function getLastSelectedDate(): string {
        return $this->lastSelectedDate;
    }

    public function setLastSelectedDate(string $lastSelectedDate): string {
        $this->lastSelectedDate = $lastSelectedDate;

        return $this->lastSelectedDate;
    }

    public function getLastTimeActive(): string {
        return $this->lastTimeActive;
    }

    public function setLastTimeActive(string $lastTimeActive): string {
        $this->lastTimeActive = $lastTimeActive;

        return $this->lastTimeActive;
    }
}