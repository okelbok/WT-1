<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/BodiesList.php';

class BodiesListService {
    private string $apiBodiesListUrl;
    private string $apiKey;

    public function __construct() {
        $this->apiBodiesListUrl = $_ENV['ASTRO_API_URL_POSITIONS'];
        $this->apiKey = $_ENV['ASTRO_API_KEY'];
    }

    public function fetchBodiesListData(User $user): array {
        $coordinates = $user->getCoordinates();
        $latitude = $coordinates['latitude'];
        $longitude = $coordinates['longitude'];
        $date = $user->getLastSelectedDate();
        $time = date('H:i:s', strtotime($user->getLastTimeActive()));

        $queryParams = http_build_query([
            'longitude' => $longitude,
            'latitude' => $latitude,
            'elevation' => 0,
            'from_date' => $date,
            'to_date' => $date,
            'time' => $time,
            'output' => 'rows'
        ]);

        $url = $this->apiBodiesListUrl . '?' . $queryParams;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $this->apiKey
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            throw new RuntimeException("CURL error: " . $error);
        }

        if ($httpCode !== 200) {
            throw new RuntimeException("API request failed with HTTP code: " . $httpCode);
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("JSON decode error: " . json_last_error_msg());
        }

        // Преобразуем данные в нужный формат для шаблона
        $bodies = [];
        foreach ($data as $bodyData) {
            $body = [
                'name' => $bodyData['name'] ?? 'Unknown',
                'imageName' => strtolower($bodyData['name'] ?? 'unknown'),
                'horizontalCoordinates' => [
                    'altitude' => $bodyData['horizontal']['altitude'] ?? 0,
                    'azimuth' => $bodyData['horizontal']['azimuth'] ?? 0
                ],
                'equatorialCoordinates' => [
                    'rightAscention' => $bodyData['equatorial']['rightAscension'] ?? 0,
                    'declination' => $bodyData['equatorial']['declination'] ?? 0
                ],
                'constellation' => $bodyData['constellation'] ?? '',
                'elongation' => $bodyData['elongation'] ?? null,
                'getMagnitude' => $bodyData['magnitude'] ?? null
            ];

            // Добавляем характеристики фазы для Луны
            if ($body['name'] === 'Moon') {
                $body['phaseCharacteristics'] = [
                    'angle' => $bodyData['phase']['angle'] ?? 0,
                    'fraction' => $bodyData['phase']['fraction'] ?? 0
                ];
            }

            $bodies[] = $body;
        }

        return $bodies;
    }

}