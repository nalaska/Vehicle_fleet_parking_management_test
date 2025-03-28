<?php

declare(strict_types=1);

namespace Fulll\App\Command\Console;

use Exception;
use Fulll\App\Command\RegisterVehicleCommand as DomainRegisterVehicleCommand;
use Fulll\App\Handler\RegisterVehicleHandler;
use Fulll\Infra\Repository\DoctrineFleetRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RegisterVehicleConsoleCommand extends Command
{
    protected static string $defaultName = 'fleet:register-vehicle';

    protected function configure(): void
    {
        $this
            ->setDescription('Enregistre un véhicule dans une flotte')
            ->setName(self::$defaultName)
            ->addArgument('fleetId', InputArgument::REQUIRED, 'L’ID de la flotte')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Numéro de plaque du véhicule');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityManager = require __DIR__ . '/../../../../bootstrap/doctrine.php';
        $repository = new DoctrineFleetRepository($entityManager);
        $handler = new RegisterVehicleHandler($repository);

        $fleetId = $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        try {
            $handler->handle(new DomainRegisterVehicleCommand($fleetId, $vehiclePlateNumber));
            $output->writeln('Véhicule enregistré avec succès.');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('Erreur : ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
