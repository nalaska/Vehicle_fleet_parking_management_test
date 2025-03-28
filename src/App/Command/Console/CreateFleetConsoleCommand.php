<?php

declare(strict_types=1);

namespace Fulll\App\Command\Console;

use Doctrine\ORM\EntityManagerInterface;
use Fulll\App\Command\CreateFleetCommand as DomainCreateFleetCommand;
use Fulll\App\Handler\CreateFleetHandler;
use Fulll\Infra\Repository\DoctrineFleetRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateFleetConsoleCommand extends Command
{
    protected static string $defaultName = 'fleet:create';

    protected function configure(): void
    {
        $this
            ->setDescription('Crée une nouvelle flotte pour un utilisateur')
            ->setName(self::$defaultName)
            ->addArgument('userId', InputArgument::REQUIRED, 'Identifiant de l’utilisateur');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = require __DIR__ . '/../../../../bootstrap/doctrine.php';
        $repository = new DoctrineFleetRepository($entityManager);
        $handler = new CreateFleetHandler($repository);

        $userId = (string) $input->getArgument('userId');
        $command = new DomainCreateFleetCommand($userId);

        $fleet = $handler->handle($command);
        $output->writeln("Flotte créée avec l'ID : " . $fleet->getFleetId());

        return Command::SUCCESS;
    }
}
