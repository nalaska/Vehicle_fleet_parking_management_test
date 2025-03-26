<?php

declare(strict_types=1);

namespace Fulll\App\Handler;

use Exception;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\Domain\Model\Location;
use Fulll\Infra\Repository\FleetRepositoryInterface;

final readonly class ParkVehicleHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {}

    /** @throws Exception */
    public function handle(ParkVehicleCommand $command): void
    {
        $fleet = $this->fleetRepository->find($command->fleetId);
        if (!$fleet) {
            throw new Exception('Fleet not found');
        }

        $vehicle = $fleet->getVehicle($command->vehiclePlateNumber);
        if (!$vehicle) {
            throw new Exception('Vehicle not registered in this fleet');
        }

        $location = new Location($command->lat, $command->lng, $command->alt);
        $vehicle->registerLocation($location);
        $this->fleetRepository->update($fleet);
    }
}
