<?php

declare(strict_types=1);

namespace Fulll\App\Command\Console;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Fulll\App\Command\ParkVehicleCommand as DomainParkVehicleCommand;
use Fulll\App\Handler\ParkVehicleHandler;
use Fulll\Infra\Repository\DoctrineFleetRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LocalizeVehicleConsoleCommand extends Command
{
    protected static string $defaultName = 'fleet:localize-vehicle';

    protected function configure(): void
    {
        $this
            ->setDescription('Localise un véhicule dans une flotte')
            ->setName(self::$defaultName)
            ->addArgument('fleetId', InputArgument::REQUIRED, 'L’ID de la flotte')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Numéro de plaque du véhicule')
            ->addArgument('lat', InputArgument::REQUIRED, 'Latitude')
            ->addArgument('lng', InputArgument::REQUIRED, 'Longitude')
            ->addArgument('alt', InputArgument::OPTIONAL, 'Altitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = require __DIR__ . '/../../../../bootstrap/doctrine.php';

        $repository = new DoctrineFleetRepository($entityManager);
        $handler = new ParkVehicleHandler($repository);

        $fleetId = (string) $input->getArgument('fleetId');
        $vehiclePlateNumber = (string) $input->getArgument('vehiclePlateNumber');

        $lat = (float) $input->getArgument('lat');
        $lng = (float) $input->getArgument('lng');
        $altRaw = $input->getArgument('alt');
        $alt = $altRaw !== null ? (float) $altRaw : null;

        try {
            $handler->handle(new DomainParkVehicleCommand($fleetId, $vehiclePlateNumber, $lat, $lng, $alt));
            $output->writeln('Véhicule localisé avec succès.');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('Erreur : ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
