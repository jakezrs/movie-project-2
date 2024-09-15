<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieService
{
    private $httpClient;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function getTrendingMovies()
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/trending/movie/day',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]
        );

        return $response->toArray();
    }

    public function getMovieDetails($id)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/' . $id,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]
        );

        return $response->toArray();
    }
}
