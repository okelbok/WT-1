<?php

declare(strict_types = 1);

abstract class BaseController {
    abstract protected function renderTemplate(string $fileName, array $data = []): string;
    abstract public function listAction();
}