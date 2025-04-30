<?php

class Body {
    private string $name;
    private array $horizontalCoordinates = [];
    private array $equatorialCoordinates = [];
    private string $constellation;
    private float $elongation;
    private float $magnitude;
    private array $phaseCharacteristics = [null, null];

    function __construct(string $name,
                         float $altitude, float $azimuth,
                         float $rightAscention, float $declination,
                         string $constellation,
                         float $elongation, float $magnitude,
                         float $angle, float $fraction) {
        $this->name = $name;
        $this->horizontalCoordinates['altitude'] = $altitude;
        $this->equatorialCoordinates['azimuth'] = $azimuth;
        $this->equatorialCoordinates['rightAscention'] = $rightAscention;
        $this->equatorialCoordinates['declination'] = $declination;
        $this->constellation = $constellation;
        $this->elongation = $elongation;
        $this->magnitude = $magnitude;
        $this->phaseCharacteristics['angle'] = $angle;
        $this->phaseCharacteristics['fraction'] = $fraction;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): Body {
        $this->name = $name;
        return $this;
    }

    public function getHorizontalCoordinates(): array {
        return $this->horizontalCoordinates;
    }

    public function setHorizontalCoordinates(float $altitude, float $azimuth): Body {
        $this->horizontalCoordinates['altitude'] = $altitude;
        $this->equatorialCoordinates['azimuth'] = $azimuth;
        return $this;
    }

    public function getEquatorialCoordinates(): array {
        return $this->equatorialCoordinates;
    }

    public function setEquatorialCoordinates(float $rightAscention, float $declination): Body {
        $this->equatorialCoordinates['rightAscention'] = $rightAscention;
        $this->equatorialCoordinates['declination'] = $declination;
        return $this;
    }

    public function getConstellation(): string {
        return $this->constellation;
    }

    public function setConstellation(string $constellation): Body {
        $this->constellation = $constellation;
        return $this;
    }

    public function getElongation(): float {
        return $this->elongation;
    }

    public function setElongation(float $elongation): Body {
        $this->elongation = $elongation;
        return $this;
    }

    public function getMagnitude(): float {
        return $this->magnitude;
    }

    public function setMagnitude(float $magnitude): Body {
        $this->magnitude = $magnitude;
        return $this;
    }

    public function getPhaseCharacteristics(): array {
        return $this->phaseCharacteristics;
    }

    public function setPhaseCharacteristics(float $angle, float $fraction): Body {
        $this->phaseCharacteristics['angle'] = $angle;
        $this->phaseCharacteristics['fraction'] = $fraction;
        return $this;
    }
}