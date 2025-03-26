<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Fulll\App\Command\Console\CreateFleetConsoleCommand;
use Fulll\App\Command\Console\LocalizeVehicleConsoleCommand;
use Fulll\App\Command\Console\RegisterVehicleConsoleCommand;
use Symfony\Component\Console\Application;

$application = new Application('Vehicle Fleet CLI', '1.0.0');

$application->add(new CreateFleetConsoleCommand());
$application->add(new RegisterVehicleConsoleCommand());
$application->add(new LocalizeVehicleConsoleCommand());

try {
    $application->run();
} catch (Exception $e) {
}
