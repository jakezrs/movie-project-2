<?php

namespace App\Command;

use App\Entity\Movie;
use App\Entity\User;
use App\Service\MovieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:import-movies')]
class ImportMoviesCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, MovieService $movieService)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->movieService = $movieService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import trending movies from TheMovieDB')
            ->addArgument('timeWindow', InputArgument::OPTIONAL, 'Time window for trending movies (day or week)', 'day');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $timeWindow = $input->getArgument('timeWindow');

        // Fetch trending movies
        $movies = $this->movieService->getTrendingMovies($timeWindow);

        foreach ($movies['results'] as $movieData) {
            // Check if movie already exists
            $existingMovie = $this->entityManager->getRepository(Movie::class)->findOneBy(['apiId' => $movieData['id']]);
            if (!$existingMovie) {
                // Create a new movie entity
                $movie = new Movie();
                $movie->setTitle($movieData['title'] ?? $movieData['name']);
                $movie->setOverview($movieData['overview'] ?? '');
                $movie->setReleaseDate($movieData['release_date'] ?? '');
                $movie->setApiId($movieData['id']);
                $movie->setPosterPath($movieData['poster_path'] ?? null);
                $movie->setTimeWindow($timeWindow);

                // Save the movie
                $this->entityManager->persist($movie);
            }
        }

        $this->entityManager->flush();

        $io->success(sprintf('Imported %d trending movies from the %s.', count($movies['results']), $timeWindow));

        return Command::SUCCESS;
    }
}
