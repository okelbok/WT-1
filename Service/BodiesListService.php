<?php

declare(strict_types = 1);

require_once __DIR__ . "/../Model/User.php";
require_once __DIR__ . "/../Model/Body.php";
require_once __DIR__ . "/../Model/BodiesList.php";

class BodiesListService {
    private string $apiBodiesListUrl;
    private string $apiKey;
    private BodiesList $currentBodiesList;

    private const string MOON_BODY_NAME = "Moon";
    private const string EARTH_BODY_NAME = "Earth";

    public function __construct() {
        $this->apiBodiesListUrl = $_ENV["ASTRO_API_URL_POSITIONS"];
        $this->apiKey = $_ENV["ASTRO_API_KEY"];
    }

    private function buildURLRequest(User $user): string {
        $coordinates = $user->getCoordinates();
        $latitude = $coordinates["latitude"];
        $longitude = $coordinates["longitude"];
        $date = DateTime::createFromFormat("d.m.Y", $user->getLastSelectedDate());
        $time =$user->getLastSelectedTime() . ":00";

        $queryParams = http_build_query(
            [
                "longitude" => $longitude,
                "latitude" => $latitude,
                "elevation" => 0,
                "from_date" => $date->format("Y-m-d"),
                "to_date" => $date->format("Y-m-d"),
                "time" => $time,
                "output" => "rows"
            ]
        );

        return $this->apiBodiesListUrl . "?" . $queryParams;
    }

    private function fetchData(string $url): array {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
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

        file_put_contents(__DIR__ . "/../resources/". rand(0, 255) . "_bodies.json", $response);

        return json_decode($response, true);
    }

    public function fetchBodiesListData(User $user): array {
        if (!isset($this->currentBodiesList)) {
            $this->currentBodiesList = new BodiesList($user->getId());
        }

        $url = $this->buildURLRequest($user);

        $data = $this->fetchData($url)["data"]["rows"];

        $bodies = $this->currentBodiesList->getBodies();
        $bodiesData = [];

        foreach ($data as $bodyData) {
            $position = $bodyData["positions"][0];

            $body = new Body(
                $bodyData["body"]["name"],

                $position["position"]["horizontal"]["altitude"]["string"],
                $position["position"]["horizontal"]["azimuth"]["string"],

                $position["position"]["equatorial"]["rightAscension"]["string"],
                $position["position"]["equatorial"]["declination"]["string"],

                $position["position"]["constellation"]["name"]
            );

            if ($body->getName() === self::MOON_BODY_NAME) {
                $phaseCharacteristics = [
                    "angle" => $position["extraInfo"]["phase"]["angel"],
                    "fraction" => $position["extraInfo"]["phase"]["fraction"],
                    "phaseName" => $position["extraInfo"]["phase"]["string"]
                ];
                $body->setPhaseCharacteristics($phaseCharacteristics);
            }

            if ($body->getName() !== self::EARTH_BODY_NAME) {
                $body->setElongation($position["extraInfo"]["elongation"]);
                $body->setMagnitude($position["extraInfo"]["magnitude"]);
            }

            $bodies[$body->getName()] = $body;
            $bodiesData[] = $body->toArray();
        }

        $this->currentBodiesList->setBodies($bodies);

        return ["bodies" => $bodiesData];
    }

}