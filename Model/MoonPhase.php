<?php

declare(strict_types = 1);

class MoonPhase extends Entity {
    private int $id;
    private float $latitude;
    private float $longitude;
    private DateTime $date;
    private string $imageUrl;

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
    
    public function getDate(): DateTime {
        return $this->date;
    }
    
    public function setDate(string $date): DateTime {
        $this->date = DateTime::createFromFormat("d.m.Y", $date);
        
        return $this->date;
    }
    
    public function getImageUrl(): string {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): string {
        $this->imageUrl = $imageUrl;

        return $this->imageUrl;
    }

    public function toArray(): array {
        return [
            "imageUrl" => $this->imageUrl,
        ];
    }
}

