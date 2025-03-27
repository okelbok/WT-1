<?php

class user
{
    private int $id;
    private array $coordinates = [];

    function __construct(int $id, float $longitude, float $latitude)
    {
        $this->id = $id;
        $this->coordinates['longitude'] = $longitude;
        $this->coordinates['latitude'] = $latitude;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function setId(int $id)
    {
        return $this->id = $id;
    }

    public function setCoordinates(float $longitude, float $latitude)
    {
        $this->coordinates['longitude'] = $longitude;
        $this->coordinates['latitude'] = $latitude;
    }
}