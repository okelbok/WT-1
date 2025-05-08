<?php

declare(strict_types=1);

require_once __DIR__ . "/Entity.php";

class User extends Entity {
    private int $id;
    private array $coordinates;
    private string $lastSelectedDate;
    private string $lastSelectedTime;

    function __construct(int $id, array $coordinates, string $lastSelectedDate, string $lastTimeActive) {
        $this->id = $id;
        $this->coordinates = $coordinates;
        $this->lastSelectedDate = $lastSelectedDate;
        $this->lastSelectedTime = $lastTimeActive;
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
        $this->coordinates["longitude"] = $longitude;
        $this->coordinates["latitude"] = $latitude;

        return $this->coordinates;
    }

    public function getLastSelectedDate(): string {
        return $this->lastSelectedDate;
    }

    public function setLastSelectedDate(string $lastSelectedDate): string {
        $this->lastSelectedDate = $lastSelectedDate;

        return $this->lastSelectedDate;
    }

    public function getLastSelectedTime(): string {
        return $this->lastSelectedTime;
    }

    public function setLastSelectedTime(string $lastSelectedTime): string {
        $this->lastSelectedTime = $lastSelectedTime;

        return $this->lastSelectedTime;
    }
}