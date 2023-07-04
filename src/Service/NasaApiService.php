<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Dotenv\Dotenv;

class NasaApiService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient) {
        $this->httpClient = $httpClient;
    }

    public function getApodData(): array
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__.'/../../.env.local');
        $apikey = $_ENV['NASA_API_KEY'];

        //utiliser HttpClient pour se connecter à l'API
        $response = $this->httpClient->request(
            'GET',
            'https://api.nasa.gov/planetary/apod', [
                'query' => [
                    'api_key' => $apikey
                ]
            ]
        );

        $statusCode = $response->getStatusCode();

        return $response->toArray();

    }

}
