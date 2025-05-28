<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Model/Entity.php";

abstract class EntityRepository {
    abstract public function read(int $id): ?Entity;
    abstract public function update(Entity $entity): void;
    abstract public function delete(Entity $entity): void;
}