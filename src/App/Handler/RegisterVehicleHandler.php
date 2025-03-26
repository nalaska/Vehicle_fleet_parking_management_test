<?php

declare(strict_types=1);

namespace Fulll\App\Handler;

use Exception;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Domain\Model\Vehicle;
use Fulll\Infra\Repository\FleetRepositoryInterface;

final readonly class RegisterVehicleHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {}

    /** @throws Exception */
    public function handle(RegisterVehicleCommand $command): void
    {
        $fleet = $this->fleetRepository->find($command->fleetId);
        if (!$fleet) {
            throw new Exception('Fleet not found');
        }

        if ($fleet->hasVehicle($command->vehiclePlateNumber)) {
            throw new Exception('Vehicle already registered in this fleet');
        }

        $vehicle = new Vehicle($command->vehiclePlateNumber);
        $fleet->registerVehicle($vehicle);
        $this->fleetRepository->update($fleet);
    }
}
