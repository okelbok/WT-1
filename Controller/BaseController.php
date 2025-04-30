<?php

abstract class BaseController {
    abstract protected function renderTemplate(string $filePath, array $data = []): string;
    abstract public function listAction();
}