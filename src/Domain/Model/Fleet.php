<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Fleet
{
    private UuidInterface $fleetId;

    private string $userId;

    /** @var Collection<int, Vehicle> */
    private Collection $vehicles;

    public function __construct(?UuidInterface $fleetId, string $userId)
    {
        $this->fleetId = $fleetId ?? Uuid::uuid4();
        $this->userId = $userId;
        $this->vehicles = new ArrayCollection();
    }

    public function getFleetId(): string
    {
        return $this->fleetId->toString();
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    /** @return Collection<int, Vehicle> */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    /** @throws Exception */
    public function registerVehicle(Vehicle $vehicle): void
    {
        foreach ($this->vehicles as $v) {
            if ($v->getPlateNumber() === $vehicle->getPlateNumber()) {
                throw new Exception('Vehicle already registered in this fleet');
            }
        }
        $vehicle->setFleet($this);
        $this->vehicles->add($vehicle);
    }

    public function hasVehicle(string $plateNumber): bool
    {
        foreach ($this->vehicles as $v) {
            if ($v->getPlateNumber() === $plateNumber) {
                return true;
            }
        }

        return false;
    }

    public function getVehicle(string $plateNumber): ?Vehicle
    {
        foreach ($this->vehicles as $v) {
            if ($v->getPlateNumber() === $plateNumber) {
                return $v;
            }
        }

        return null;
    }
}
