<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Dotenv\Dotenv;

class NasaApiService
{
    public function __construct(
        private HttpClientInterface $httpClient
    ) {
    }

    public function getApodData(): array
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__.'/.env');
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

        if ($statusCode === 200) {
            $content = $response->toArray();
            return $content;
        } else {
            throw new \Exception("Erreur lors de la requête à l'API de la NASA");
        }

    }

}
