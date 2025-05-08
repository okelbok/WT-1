<?php

declare(strict_types=1);

class MoonPhase extends Entity {
    private int $id;
    private string $imageUrl;

    function __construct(int $id, string $imageUrl) {
        $this->id = $id;
        $this->imageUrl = $imageUrl;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): int {
        $this->id = $id;

        return $this->id;
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

