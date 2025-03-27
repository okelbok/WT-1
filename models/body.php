<?php

class body {
    private int $id;
    private int $name;
    private string $constellation;
    private float $elongation;
    private float $magnitude;
    private array $horizontalCoordinates = [];
    private array $equatorialCoordinates = [];
    private array $phaseCharateristics = [null, null];

    function __construct($id, $name, $altitude, $azimuth, $constellation, $rightAscention, $declination, $cOnstellation, $elongation, $magnitude, $elOngation, $mAgnitude, $angle, $fraction) {
        $this->id = $id;
        $this->name = $name;
        $this->horizontalCoordinates['altitude'] = $altitude;
        $this->equatorialCoordinates['azimuth'] = $azimuth;
        $this->equatorialCoordinates['rightAscention'] = $rightAscention;
        $this->equatorialCoordinates['declination'] = $declination;
        $this->constellation = $cOnstellation;
        $this->elongation = $elOngation;
        $this->magnitude = $mAgnitude;
        $this->phaseCharateristics['angle'] = $angle;
        $this->phaseCharateristics['fraction'] = $fraction;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): int {
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

    public function getMagnitude(): float {
        return $this->magnitude;
    }

    public function getPhaseCharateristics(): array {
        return $this->phaseCharateristics;
    }

    public function setId($id) {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setHorizontalCoordinates(float $altitude, float $azimuth) {
        $this->horizontalCoordinates['altitude'] = $altitude;
        $this->equatorialCoordinates['azimuth'] = $azimuth;
    }

    public function setEquatorialCoordinates(float $rightAscention, float $declination) {
        $this->equatorialCoordinates['rightAscention'] = $rightAscention;
        $this->equatorialCoordinates['declination'] = $declination;
    }

    public function setConstellation(string $constellation) {
        $this->constellation = $constellation;
    }

    public function setElongation(float $elongation) {
        $this->elongation = $elongation;
    }

    public function setMagnitude(float $magnitude) {
        $this->magnitude = $magnitude;
    }

    public function setPhaseCharateristics(float $angle, float $fraction) {
        $this->phaseCharateristics['angle'] = $angle;
        $this->phaseCharateristics['fraction'] = $fraction;
    }

}