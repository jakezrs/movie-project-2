<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MoviePageController extends AbstractController
{
    #[Route('/', name: 'trending_movies_page')]

    public function index(): Response
    {
        return $this->render('movies/trending.html.twig');
    }

    #[Route('/movies/{movieId}', name: 'detail_movie_page')]
    public function detail($movieId): Response
    {
        return $this->render('movies/detail.html.twig', [
            'movieId' => $movieId
        ]);
    }
}
