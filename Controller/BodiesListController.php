<?php

declare(strict_types=1);

require_once "BaseController.php";
require_once "MoonPhaseController.php";
require_once __DIR__.'/../Core/TemplateEngine.php';
require_once __DIR__ . "/../Model/BodiesList.php";
require_once __DIR__ . "/../Service/BodiesListService.php";

class BodiesListController extends BaseController {
    public function listAction(): void
    {
        echo file_get_contents(htmlspecialchars(__DIR__ . '/../view/public/html/index.html'));
    }
}