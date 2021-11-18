<?php

namespace App\Service;

use App\Entity\System;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

class DataForSeo
{
    private string $login;
    private string $password;
    private string $baseUrl;

    public function __construct(
        $login,
        $password,
        $baseUrl
    )
    {
        $this->login = $login;
        $this->password = $password;
        $this->baseUrl = $baseUrl;
    }

    public function getLocations($system): array
    {
        $system = strtolower($system);
        $url = $this->baseUrl . "/v3/serp/$system/locations";

        $client = HttpClient::create();

        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => "Basic " . base64_encode("{$this->login}:{$this->password}"),
                'Content-Type'  => "application/json"
            ]
        ]);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            return $response->toArray()['tasks'][0]['result'];
        }
        return [];
    }

    public function createTask(System $system, $locationName, $keyword): ResponseInterface
    {
        $key = $system->getKey();
        $url = $this->baseUrl . "/v3/serp/$key/organic/task_post";

        $client = HttpClient::create();

        return $client->request('POST', $url, [
            'headers' => [
                'Authorization' => "Basic " . base64_encode("{$this->login}:{$this->password}"),
                'Content-Type'  => "application/json"
            ],
            'json'    => [
                [
                    'language_code' => 'en',
                    'keyword'       => $keyword,
                    'location_name' => $locationName
                ]
            ]
        ]);
    }
}