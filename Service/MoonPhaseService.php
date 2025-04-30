<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . "/../Model/MoonPhase.php";

class MoonPhaseService {
    private string $apiMoonPhaseUrl;
    private string $apiKey;

    public function __construct() {
        $this->apiMoonPhaseUrl = $_ENV['ASTRO_API_URL_MOON_PHASE'];
        $this->apiKey = $_ENV['ASTRO_API_KEY'];
    }

    public function fetchMoonPhaseData(User $user): array {
        $coordinates = $user->getCoordinates();
        $latitude = $coordinates['latitude'];
        $longitude = $coordinates['longitude'];
        $date = $user->getLastSelectedDate();

        $data = [
            'style' => [
                'moonStyle' => 'default',
                'backgroundStyle' => 'stars',
                'backgroundColor' => '#000000',
                'headingColor' => '#ffffff',
                'textColor' => '#ffffff'
            ],
            'observer' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'date' => $date
            ],
            'view' => [
                'type' => 'portrait-simple',
                'parameters' => []
            ]
        ];

        $ch = curl_init($this->apiMoonPhaseUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $this->apiKey,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        $firstValue = reset($decodedResponse);
        $imageUrl = $firstValue['imageUrl'];

        return ['imageUrl' => $imageUrl];
    }
}
