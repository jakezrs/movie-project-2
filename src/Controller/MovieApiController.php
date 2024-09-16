<?php

namespace App\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class MovieApiController extends AbstractController
{
    private $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    #[Route('/api/movies/search', name: 'api_movies_search')]
    public function searchMovies(Request $request): JsonResponse
    {
        $query = $request->query->get('query');
        
        $movies = $this->movieService->searchMoviesFromBdd($query);

        return $this->json($movies);
}

    #[Route('/api/movies/trending/{timeWindow}', name: 'api_movies_trending')]
    public function getTrendingMovies($timeWindow): JsonResponse
    {
        $movies = $this->movieService->getTrendingMoviesFromBdd($timeWindow);

        return $this->json($movies);
    }

    #[Route('/api/movies/{id}', name: 'api_movie_detail')]
    public function getMovieDetail(int $id): JsonResponse
    {
        $movie = $this->movieService->getMovieDetailsFromBdd($id);

        return $this->json($movie);
    }
}
