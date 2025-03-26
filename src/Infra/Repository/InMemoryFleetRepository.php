<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\Domain\Model\Fleet;

final class InMemoryFleetRepository implements FleetRepositoryInterface
{
    /** @var array<string, Fleet> */
    private array $fleets = [];

    public function find(string $fleetId): ?Fleet
    {
        return $this->fleets[$fleetId] ?? null;
    }

    public function add(Fleet $fleet): void
    {
        $this->fleets[$fleet->getFleetId()] = $fleet;
    }

    public function update(Fleet $fleet): void
    {
        $this->fleets[$fleet->getFleetId()] = $fleet;
    }
}
