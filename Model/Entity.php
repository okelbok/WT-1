<?php

declare(strict_types=1);

abstract class Entity {
    private int $id;

    abstract public function getId(): int;

    abstract public function setId(int $id): int;
}