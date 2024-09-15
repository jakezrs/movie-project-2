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

    public function getTrendingMovies($timeWindow)
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.themoviedb.org/3/trending/movie/' . $timeWindow,
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
        $response = $this->httpClient->request(
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

    public function addMovies()
    {
        $movies = $this->getMovies();

        $response = new JsonResponse($this->persistMovies($movies), 200);

        return $response;
    }

    public function getMovies()
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                'https://api.themoviedb.org/3/movie/' . $id,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey
                    ]
                ]
            );
        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = $response->getBody()->getContents();

            return new JsonResponse(json_decode($jsonBody), 404);
        }

        $jsonResponse = json_decode($res->getBody()->getContents());

        return $jsonResponse;
    }

    public function persistMovies($jsonResponse)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($jsonResponse->results as $result) {
            $movie = new Movie();

            $movie->setTitle($result->title);
            $movie->setPosterPath($result->poster_path);
            $movie->setOverview($result->overview);
            $movie->setReleaseDate($result->release_date);

            $em->persist($movie);
        }

        $em->flush();

        return new JsonResponse($movie, 201);
    }
}