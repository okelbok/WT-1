<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . "/Core/EntityManager.php";
require_once __DIR__ . "/Core/Router.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$entityManager = EntityManager::getInstance();
$router = new Router();

$router->dispatch($_SERVER['REQUEST_URI']);
$entityManager->closeConnection();