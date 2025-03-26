<?php

declare(strict_types=1);

namespace Fulll\App\Command;

final readonly class ParkVehicleCommand
{
    public function __construct(
        public string $fleetId,
        public string $vehiclePlateNumber,
        public float $lat,
        public float $lng,
        public ?float $alt = null,
    ) {}
}
