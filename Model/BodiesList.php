<?php

declare(strict_types = 1);

require_once __DIR__.  "/Entity.php";

class BodiesList extends Entity {
    private int $id;
    private float $latitude;
    private float $longitude;
    private DateTime $date;
    private DateTime $time;
    private array $bodies;

    private const string MOON_BODY_NAME = "Moon";
    private const string EARTH_BODY_NAME = "Earth";

    public function __construct(int $id) {
        $this->id = $id;
        $this->bodies = array(
            "Sun" => null,
            "Moon" => null,
            "Mercury" => null,
            "Venus" => null,
            "Earth" => null,
            "Mars" => null,
            "Jupiter" => null,
            "Saturn" => null,
            "Uranus" => null,
            "Neptune" => null
        );
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): int {
        $this->id = $id;

        return $this->id;
    }

    public function getLatitude(): float {
        return $this->latitude;
    }
    
    public function setLatitude(float $latitude): float {
        $this->latitude = $latitude;
        
        return $this->latitude;
    }
    
    public function getLongitude(): float {
        return $this->longitude;
    }
    
    public function setLongitude(float $longitude): float {
        $this->longitude = $longitude;
        
        return $this->longitude;
    }
    
    public function getDate(): string {
        return $this->date->format("d.m.Y");
    }
    
    public function setDate(string $date): DateTime {
        $this->date = DateTime::createFromFormat("Y-m-d", $date);
        
        return $this->date;
    }
    
    public function getTime(): DateTime {
        return $this->time;
    }
    
    public function setTime(string $time): DateTime {
        $this->time = DateTime::createFromFormat("H:i:s", $time . ":00");
        
        return $this->time;
    }
    
    public function getBodies(): array {
        return $this->bodies;
    }

    public function setBodies(array $bodies): array {
        $this->bodies = $bodies;

        return $this->bodies;
    }
}