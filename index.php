<?php

require_once __DIR__ . "/Core/EntityManager.php";
require_once __DIR__ . "/Core/Router.php";

$entityManager = new EntityManager();
$router = new Router();

$router->dispatch($_SERVER['REQUEST_URI']);