<?php

declare(strict_types = 1);

require_once __DIR__ . "/BaseController.php";

require_once __DIR__ . "/../Core/TemplateEngine.php";

require_once __DIR__ . "/../Model/User.php";

require_once __DIR__ . "/../Service/BodiesListService.php";
require_once __DIR__ . "/../Service/MoonPhaseService.php";

class CalendarController extends BaseController {
    private TemplateEngine $templateEngine;
    private BodiesListService $bodiesListService;
    private MoonPhaseService $moonPhaseService;
    private ?User $currentUser = null;

    private const string TEMPLATE_BASE_PATH = __DIR__ . "/../view/public/html/";

    public function __construct() {
        $this->templateEngine = new TemplateEngine();
        $this->bodiesListService = new BodiesListService();
        $this->moonPhaseService = new MoonPhaseService();
    }

    protected function renderTemplate(string $fileName, array $data = []): string {
        $filePath = self::TEMPLATE_BASE_PATH . $fileName;

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
            "dateTime" => (isset($_POST["date"]) && isset($_POST["time"])) ?
                DateTime::createFromFormat("d.m.Y, H:i", $_POST["date"] . ", " . $_POST["time"])->
                format("F j Y, H:i") : "",
        ];
    }

    private function showStartPage(): void {
        echo $this->renderTemplate("index.html", $this->getHeaderData());
    }

    private function updateCurrentUser(): void {
        if ($this->currentUser === null) {
            $this->currentUser = new User(rand(1, 255));
        }

        $this->currentUser->setCoordinates((float)$_POST["latitude"], (float)$_POST["longitude"]);
        $this->currentUser->setLastSelectedDate($_POST["date"]);
        $this->currentUser->setLastSelectedTime($_POST["time"]);
    }

    private function executeAstroSearch(): void {
        $this->updateCurrentUser();

        $data = array_merge(
            $this->getHeaderData(),
            $this->bodiesListService->fetchBodiesListData($this->currentUser),
            $this->moonPhaseService->fetchMoonPhaseData($this->currentUser)
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