<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

use Exception;

final class Vehicle
{
    private ?int $id = null;

    private string $plateNumber;

    private Fleet $fleet;

    private ?Location $currentLocation = null;

    public function __construct(string $plateNumber)
    {
        $this->plateNumber = $plateNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function setFleet(Fleet $fleet): void
    {
        $this->fleet = $fleet;
    }

    public function getFleet(): Fleet
    {
        return $this->fleet;
    }

    public function getCurrentLocation(): ?Location
    {
        return $this->currentLocation;
    }

    /** @throws Exception */
    public function registerLocation(Location $location): void
    {
        if ($this->currentLocation !== null && $this->currentLocation->equals($location)) {
            throw new Exception('Vehicle already parked at this location');
        }
        $this->currentLocation = $location;
    }
}
