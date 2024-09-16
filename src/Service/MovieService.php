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

    public function searchMovies(string $query)
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.themoviedb.org/3/search/movie?query=' . $query,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]
        );

        return $response->toArray();
    }

    public function searchMoviesFromBdd(string $query)
    {
        $qb = $this->entityManager->createQueryBuilder('m');

        $qb
            ->select('m')
            ->from(Movie::class, 'm')
            ->where('m.title LIKE :query')
            ->setParameter('query', '%' . $query . '%');

        return $qb->getQuery()->getArrayResult();
    }

    public function getTrendingMoviesFromBdd(string $timeWindow): array
    {
        $qb = $this->entityManager->createQueryBuilder('m');
        $qb
            ->select('m')
            ->from(Movie::class, 'm')
            ->where('m.timeWindow = :timeWindow')
            ->setParameter('timeWindow', $timeWindow);

        return $qb->getQuery()->getArrayResult();
    }

    public function getMovieDetailsFromBdd($id): array
    {
        $movie = $this->entityManager->getRepository(Movie::class)->findById($id);

        if (!$movie) {
            return new JsonResponse(['error' => 'Movie not found'], Response::HTTP_NOT_FOUND);
        }

        return [
            'id' => $movie[0]->getId(),
            'title' => $movie[0]->getTitle(),
            'original_title' => $movie[0]->getOriginalTitle(),
            'overview' => $movie[0]->getOverview(),
            'release_date' => $movie[0]->getReleaseDate(),
            'poster_path' => $movie[0]->getPosterPath(),
        ];
    }

    
    public function getTrendingMovies(string $timeWindow)
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.themoviedb.org/3/trending/movie/' . $timeWindow . '?language=fr-FR',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]
        );

        return $response->toArray();
    }

    /*
    public function getMovieDetails(int $id)
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.themoviedb.org/3/movie/' . $id . '?language=fr-FR',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]
        );

        return $response->toArray();
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
    */
}