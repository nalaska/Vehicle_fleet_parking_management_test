<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity]
#[ORM\Table(name: 'vehicle')]
class Vehicle
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(name: 'plate_number', type: 'string', length: 255)]
    private string $plateNumber;

    #[ORM\ManyToOne(targetEntity: Fleet::class, inversedBy: 'vehicles')]
    #[ORM\JoinColumn(name: 'fleet_id', referencedColumnName: 'fleet_id', nullable: false)]
    private Fleet $fleet;

    #[ORM\Embedded(class: Location::class, columnPrefix: 'location_')]
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
