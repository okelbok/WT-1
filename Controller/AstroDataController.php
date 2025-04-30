<?php

declare(strict_types=1);

require_once "BaseController.php";

require_once __DIR__.'/../Core/TemplateEngine.php';
require_once __DIR__.'/../Model/User.php';
require_once __DIR__ . "/../Service/BodiesListService.php";
require_once __DIR__ . "/../Service/MoonPhaseService.php";

class AstroDataController extends BaseController {
    private TemplateEngine $templateEngine;
    private BodiesListService $bodiesListService;
    private MoonPhaseService $moonPhaseService;
    private string $templateBasePath = __DIR__ . "/../view/public/html/";

    public function __construct() {
        $this->templateEngine = new TemplateEngine();
        $this->bodiesListService = new BodiesListService();
        $this->moonPhaseService = new MoonPhaseService();
    }

    protected function renderTemplate(string $filePath, array $data = []): string {
        $filePath = $this->templateBasePath . $filePath;
        if (file_exists($filePath)) {
            return $this->templateEngine->render($filePath, $data);
        }

        return "";
    }

    private function showStartPage(): void {
        echo file_get_contents(htmlspecialchars($this->templateBasePath . "/index.html"));
    }

    private function executeAstroSearch(): void {
        $user = new User(
            rand(1, 255),
            [
                $_COOKIE['latitude'],
                $_COOKIE['longitude'],
            ],
            $_COOKIE['selectedDate'],
            $_COOKIE['time']
        );

        $bodiesListData = $this->bodiesListService->fetchBodiesListData($user);
        $moonPhaseData = $this->moonPhaseService->fetchMoonPhaseData($user);

        echo $this->renderTemplate("header.html") .
            $this->renderTemplate("bodies_list.html", $bodiesListData) .
            $this->renderTemplate("moon_phase.html", $moonPhaseData) .
            $this->renderTemplate("footer.html");
    }

    public function listAction(): void
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $this->showStartPage();
                break;
            case "POST":
                $this->executeAstroSearch();
        }
    }
}