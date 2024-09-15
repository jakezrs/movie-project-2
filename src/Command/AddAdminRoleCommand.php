<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddAdminRoleCommand extends Command
{
    protected static $defaultName = 'app:add-admin-role';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Ajoute le rôle ROLE_ADMIN à un utilisateur')
            ->addArgument('email', InputArgument::OPTIONAL, 'Email de l\'utilisateur');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if (!$email) {
            $helper = $this->getHelper('question');
            $question = new Question('Veuillez entrer l\'email de l\'utilisateur : ');
            $email = $helper->ask($input, $output, $question);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $io->error('Utilisateur non trouvé.');
            return Command::FAILURE;
        }

        $roles = $user->getRoles();
        if (!in_array('ROLE_ADMIN', $roles, true)) {
            $roles[] = 'ROLE_ADMIN';
            $user->setRoles($roles);
            $this->entityManager->flush();

            $io->success('Le rôle ROLE_ADMIN a été ajouté à l\'utilisateur.');
        } else {
            $io->warning('L\'utilisateur a déjà le rôle ROLE_ADMIN.');
        }

        return Command::SUCCESS;
    }
}
