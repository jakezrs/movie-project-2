<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;

class MovieService
{
    private $httpClient;
    private $apiKey;
    private $entityManager;

    public function __construct(HttpClientInterface $httpClient, string $apiKey, EntityManagerInterface $entityManager)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->entityManager = $entityManager;
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

        $response = new JsonResponse($dash, 200);

        return $response;
    }

    public function getMovieDetailsFromBdd($id)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);

        $response = new JsonResponse($dash, 200);

        return $response;
    }

    public function addMovies(string $timeWindow)
    {
        $trendingMovies = $this->getTrendingMovies($timeWindow);

        $response = new JsonResponse($this->persistTrendingMovies($trendingMovies, $timeWindow), 200);

        return $response;
    }

    public function persistTrendingMovies(array $trendingMovies, string $timeWindow)
    {
        foreach ($trendingMovies['results'] as $trendingMovie) {
            $movie = new Movie();

            $movie->setTitle($trendingMovie['title']);
            $movie->setPosterPath($trendingMovie['poster_path']);
            $movie->setOverview($trendingMovie['overview']);
            $movie->setReleaseDate($trendingMovie['release_date']);
            $movie->setTimeWindow($timeWindow);

            $this->entityManager->persist($movie);
        }

        $this->entityManager->flush();

        return new JsonResponse($movie, 201);
    }
}