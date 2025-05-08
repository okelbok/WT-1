<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Model/MoonPhase.php";

class MoonPhaseRepository extends EntityRepository {
    public function create(Entity $entity): void {

    }

    public function read(Entity $entity): Entity {
        return $entity;
    }

    public function update(Entity $entity): void {

    }

    public function delete(Entity $entity): void {

    }

    public function find(int $id): Entity {
        $moonPhase = new MoonPhase($id);
        return $moonPhase;
    }
}