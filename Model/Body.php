<?php

declare(strict_types = 1);

class Body {
    private string $name;
    private array $horizontalCoordinates;
    private array $equatorialCoordinates;
    private string $constellation;
    private float $elongation;
    private float $magnitude;
    private array $phaseCharacteristics = [
        "angle" => null,
        "fraction" => null,
        "phaseName" => null
    ];

    function __construct(string $name,
                         string  $altitude, string $azimuth,
                         string  $rightAscension, string $declination,
                         string $constellation) {
        $this->name = $name;

        $this->horizontalCoordinates["altitude"] = $altitude;
        $this->horizontalCoordinates["azimuth"] = $azimuth;

        $this->equatorialCoordinates["rightAscension"] = $rightAscension;
        $this->equatorialCoordinates["declination"] = $declination;

        $this->constellation = $constellation;

        $this->elongation = 0;
        $this->magnitude = 0;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getHorizontalCoordinates(): array {
        return $this->horizontalCoordinates;
    }

    public function getEquatorialCoordinates(): array {
        return $this->equatorialCoordinates;
    }

    public function getConstellation(): string {
        return $this->constellation;
    }

    public function getElongation(): float {
        return $this->elongation;
    }

    public function setElongation(float $elongation): float {
        $this->elongation = $elongation;

        return $this->elongation;
    }

    public function getMagnitude(): float {
        return $this->magnitude;
    }

    public function setMagnitude(float $magnitude): float {
        $this->magnitude = $magnitude;

        return $this->magnitude;
    }

    public function getPhaseCharacteristics(): array {
        return $this->phaseCharacteristics;
    }

    public function setPhaseCharacteristics(array $phaseCharacteristics): array {
        $this->phaseCharacteristics = $phaseCharacteristics;

        return $this->phaseCharacteristics;
    }

    public function toArray(): array {
        return [
            "name" => $this->name,
            "imageName" => strtolower($this->name) . ".png",
            "horizontalCoordinates" => $this->horizontalCoordinates,
            "equatorialCoordinates" => $this->equatorialCoordinates,
            "constellation" => $this->constellation,
            "elongation" => $this->elongation,
            "magnitude" => $this->magnitude,
            "phaseCharacteristics" => $this->phaseCharacteristics,
        ];
    }
}