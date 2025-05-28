<?php

declare(strict_types = 1);

require_once __DIR__ . "/Entity.php";

class User extends Entity {
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $salt;
    private string $token;
    private bool $isVerified;
    private ?float $longitude;
    private ?float $latitude;
    private ?DateTime $lastSelectedDate;
    private ?DateTime $lastSelectedTime;

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

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): string {
        $this->firstName = $firstName;

        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): string {
        $this->lastName = $lastName;

        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): string {
        $this->email = $email;

        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): string {
        $this->password = $password;

        return $this->password;
    }

    public function getSalt(): string {
        return $this->salt;
    }

    public function setSalt(string $salt): string {
        $this->salt = $salt;

        return $this->salt;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function setToken(string $token): string {
        $this->token = $token;

        return $this->token;
    }

    public function getIsVerified(): bool {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): bool {
        $this->isVerified = $isVerified;

        return $this->isVerified;
    }

    public function getLatitude(): ?float {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): float {
        $this->latitude = $latitude;

        return $this->latitude;
    }

    public function getLongitude(): ?float {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): float {
        $this->longitude = $longitude;

        return $this->longitude;
    }

    public function getLastSelectedDate(): DateTime {
        return $this->lastSelectedDate;
    }

    public function setLastSelectedDate(string $lastSelectedDate): DateTime {
        $this->lastSelectedDate = DateTime::createFromFormat("d.m.Y", $lastSelectedDate);

        return $this->lastSelectedDate;
    }

    public function getLastSelectedTime(): DateTime {
        return $this->lastSelectedTime;
    }

    public function setLastSelectedTime(string $lastSelectedTime): DateTime {
        $this->lastSelectedTime = DateTime::createFromFormat("H:i:s", $lastSelectedTime . ":00");

        return $this->lastSelectedTime;
    }
}