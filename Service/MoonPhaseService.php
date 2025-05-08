<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Model/User.php";
require_once __DIR__ . "/../Model/MoonPhase.php";

class MoonPhaseService {
    private string $apiMoonPhaseUrl;
    private string $apiKey;
    private MoonPhase $currentMoonPhase;

    public function __construct() {
        $this->apiMoonPhaseUrl = $_ENV["ASTRO_API_URL_MOON_PHASE"];
        $this->apiKey = $_ENV["ASTRO_API_KEY"];
    }

    private function buildPostFields(User $user): string {
        $postFields = [
            "style" => [
                "moonStyle" => "default",
                "backgroundStyle" => "stars",
                "backgroundColor" => "#000000",
                "headingColor" => "#ffffff",
                "textColor" => "#ffffff"
            ],
            "observer" => [
                "latitude" => $user->getCoordinates()["latitude"],
                "longitude" => $user->getCoordinates()["longitude"],
                "date" => DateTime::createFromFormat("d.m.Y", $user->getLastSelectedDate())->format("Y-m-d"),
            ],
            "view" => [
                "type" => "portrait-simple",
                "parameters" => []
            ]
        ];

        return json_encode($postFields);
    }

    private function fetchData(User $user): array {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiMoonPhaseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->buildPostFields($user),
            CURLOPT_HTTPHEADER => [
                "Authorization: " . $this->apiKey,
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_errno($curl);

        curl_close($curl);

        if ($err !== 0) {
            http_response_code($err);
            exit();
        }

        return json_decode($response, true);
    }

    public function fetchMoonPhaseData(User $user): array {
        $imageUrl = $this->fetchData($user)["data"]["imageUrl"];

        return ["moonPhase" => ["imageUrl" => $imageUrl]];
    }
}
