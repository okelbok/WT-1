<?php

declare(strict_types = 1);

require_once __DIR__ . "/BodiesListService.php";
require_once __DIR__ . "/MoonPhaseService.php";

class CalendarService {
    private BodiesListService $bodiesListService;
    private MoonPhaseService $moonPhaseService;
    public function __construct() {
        $this->bodiesListService = new BodiesListService();
        $this->moonPhaseService = new MoonPhaseService();
    }

    public function getCalendarData(User $user): array {
        return array_merge(
            $this->bodiesListService->getBodiesList($user),
            $this->moonPhaseService->getMoonPhase($user),
        );
    }
}