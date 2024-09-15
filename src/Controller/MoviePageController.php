<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MoviePageController extends AbstractController
{
    /**
     * @Route("/trending/movies", name="trending_movies_page")
     */
    #[Route('/trending/movies', name: 'trending_movies_page')]

    public function index(): Response
    {
        return $this->render('movies/trending.html.twig');
    }
}
