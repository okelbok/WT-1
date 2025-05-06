<?php

declare(strict_types=1);

require_once "BaseController.php";

require_once __DIR__ . "/../Core/TemplateEngine.php";
require_once __DIR__ . "/../Model/User.php";
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

    protected function renderTemplate(string $fileName, array $data = []): string {
        $filePath = $this->templateBasePath . $fileName;
        if (file_exists($filePath)) {
            return $this->templateEngine->render($filePath, $data);
        }

        return "";
    }

    private function getHeaderData(): array {
        return [
            "isApplied" => isset($_POST["date"]),
            "date" => $_POST["date"] ?? "",
            "latitude" => $_POST["latitude"] ?? "",
            "longitude" => $_POST["longitude"] ?? "",
            "time" => $_POST["time"] ?? "",
        ];
    }

    private function showStartPage(): void {
        echo $this->renderTemplate("index.html", $this->getHeaderData());
    }

    private function executeAstroSearch(): void {
        $user = new User(
            rand(1, 255),
            [
                'latitude' => $_POST['latitude'],
                'longitude' => $_POST['longitude'],
            ],
            $_POST['date'],
            $_POST['time']
        );

        $data = array_merge(
            $this->getHeaderData(),
            $this->bodiesListService->fetchBodiesListData($user),
            $this->moonPhaseService->fetchMoonPhaseData($user)
        );

        echo $this->renderTemplate("index.html", $data);
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