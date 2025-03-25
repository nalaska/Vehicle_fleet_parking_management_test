<?php
namespace Fulll\App\Handler;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\Infra\Repository\FleetRepositoryInterface;
use Fulll\Domain\Model\Fleet;

final readonly class CreateFleetHandler
{
    public function __construct(private FleetRepositoryInterface $fleetRepository)
    {}

    public function handle(CreateFleetCommand $command): Fleet
    {
        $fleetId = uniqid('fleet_', true);
        $fleet = new Fleet($fleetId, $command->userId);
        $this->fleetRepository->add($fleet);
        return $fleet;
    }
}
