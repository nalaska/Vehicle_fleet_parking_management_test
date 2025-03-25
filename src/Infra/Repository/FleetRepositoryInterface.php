<?php
namespace Fulll\Infra\Repository;

use Fulll\Domain\Model\Fleet;

interface FleetRepositoryInterface
{
    public function find(string $fleetId): ?Fleet;
    public function add(Fleet $fleet): void;
    public function update(Fleet $fleet): void;
}
