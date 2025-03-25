<?php
namespace Fulll\Domain\Model;

use Exception;

final class Fleet
{
    /** @var Vehicle[] */
    private array $vehicles = [];

    public function __construct(
        public readonly string $fleetId,
        public readonly string $userId
    ) {}

    /**
     * @throws Exception
     */
    public function registerVehicle(Vehicle $vehicle): void
    {
        foreach ($this->vehicles as $v) {
            if ($v->plateNumber === $vehicle->plateNumber) {
                throw new Exception("Vehicle already registered in this fleet");
            }
        }
        $this->vehicles[] = $vehicle;
    }

    public function hasVehicle(string $plateNumber): bool
    {
        foreach ($this->vehicles as $v) {
            if ($v->plateNumber === $plateNumber) {
                return true;
            }
        }
        return false;
    }

    public function getVehicle(string $plateNumber): ?Vehicle
    {
        foreach ($this->vehicles as $v) {
            if ($v->plateNumber === $plateNumber) {
                return $v;
            }
        }
        return null;
    }
}
