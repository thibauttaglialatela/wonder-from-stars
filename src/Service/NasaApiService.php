<?php

namespace App\Service;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NasaApiService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function getApiKey(): string
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__.'/../../.env.local');

        return $_ENV['NASA_API_KEY'];
    }

    public function getApod(): array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.nasa.gov/planetary/apod',
            [
                'query' => [
                    'api_key' => $this->getApiKey(),
                ],
            ]
        );

        return $response->toArray();
    }

    public function getSeveralPictures(string $date): array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.nasa.gov/planetary/apod',
            [
                'query' => [
                    'api_key' => $this->getApiKey(),
                    'start_date' => $date,
                ],
            ]
        );

        return $response->toArray();
    }
}
