<?php

declare(strict_types=1);

namespace Fulll\App\Command;

final readonly class RegisterVehicleCommand
{
    public function __construct(
        public string $fleetId,
        public string $vehiclePlateNumber,
    ) {}
}
