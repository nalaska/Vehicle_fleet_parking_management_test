<?php
namespace Fulll\Domain\Model;

use Exception;

final class Vehicle
{
    /** @var Location[] */
    private array $locations = [];

    public function __construct(
        public readonly string $plateNumber
    ) {}

    /**
     * @throws Exception
     */
    public function registerLocation(Location $location): void
    {
        // Vérifie si le véhicule est déjà à cette localisation
        if (!empty($this->locations)) {
            $lastLocation = end($this->locations);
            if ($lastLocation->equals($location)) {
                throw new Exception("Vehicle already parked at this location");
            }
        }
        $this->locations[] = $location;
    }

    public function getCurrentLocation(): ?Location
    {
        return $this->locations ? end($this->locations) : null;
    }
}
