<?php

declare(strict_types = 1);

require_once __DIR__ . "/Entity.php";

class User extends Entity {
    private int $id;
    private ?array $coordinates;
    private ?string $lastSelectedDate;
    private ?string $lastSelectedTime;

    function __construct(int $id) {
        $this->id = $id;
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

    public function setCoordinates(float $latitude, float $longitude): array {
        $this->coordinates["latitude"] = $latitude;
        $this->coordinates["longitude"] = $longitude;

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