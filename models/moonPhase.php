<?php

class moonPhase {
    private int $id;
    private float $timestamp;
    function __construct(int $id, float $timestamp) {
        $this->id = $id;
        $this->timestamp = $timestamp;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTimestamp(): float {
        return $this->timestamp;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setTimestamp(float $timestamp) {
        $this->timestamp = $timestamp;
    }
}

