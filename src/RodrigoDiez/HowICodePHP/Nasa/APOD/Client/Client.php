<?php

namespace RodrigoDiez\HowICodePHP\Nasa\APOD\Client;

use GuzzleHttp\Client as HttpClient;
use RodrigoDiez\HowICodePHP\Nasa\APOD\APOD;


class Client
{
    private $httpClient;
    private $endpoint;
    private $apiKey;

    public function __construct(HttpClient $httpClient, $endpoint, $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = $endpoint;
        $this->apiKey = $apiKey;
    }

    public function get($time = "yesterday")
    {
        $datetime = new \DateTime($time);
        $response = $this->httpClient->request(
            'GET',
            $this->endpoint,
            ['query' => [
                'api_key' => $this->apiKey,
                'date' => $datetime->format('Y-m-d')
            ]
        ]);

        $responseBody = json_decode((string) $response->getBody());

        return new APOD(
            $responseBody->title,
            $responseBody->explanation,
            $responseBody->url,
            $responseBody->hdurl,
            $responseBody->copyright,
            new \DateTime($responseBody->date)
        );
    }
}
