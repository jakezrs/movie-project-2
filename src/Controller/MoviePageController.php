<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MoviePageController extends AbstractController
{
    /**
     * Renders the trending movies page.
     *
     * @return Response The rendered response containing the trending movies page.
     */
    #[Route('/', name: 'trending_movies_page')]

    public function index(): Response
    {
        return $this->render('movies/trending.html.twig');
    }

    /**
     * Handles HTTP requests for the movie detail page.
     *
     * @param int $movieId The ID of the movie to display.
     * @return Response The HTTP response containing the rendered movie detail page.
     */
    #[Route('/movies/{movieId}', name: 'detail_movie_page')]
    public function detail($movieId): Response
    {
        return $this->render('movies/detail.html.twig', [
            'movieId' => $movieId
        ]);
    }
}
