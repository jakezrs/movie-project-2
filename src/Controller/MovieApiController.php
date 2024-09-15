<?php

namespace App\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MovieApiController extends AbstractController
{
    private $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    #[Route('/api/movies/trending/{timeWindow}', name: 'api_movies_trending')]
    public function getTrendingMovies($timeWindow): JsonResponse
    {
        $movies = $this->movieService->addMovies($timeWindow);

        return $this->json($movies['results']);
    }

    #[Route('/api/movies/{id}', name: 'api_movie_detail')]
    public function getMovieDetail(int $id): JsonResponse
    {
        $movie = $this->movieService->getMovieDetails($id);

        return $this->json($movie);
    }
}
