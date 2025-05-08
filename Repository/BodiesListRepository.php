<?php

class BodiesListRepository extends EntityRepository {
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
        return new BodiesList($id);
    }
}