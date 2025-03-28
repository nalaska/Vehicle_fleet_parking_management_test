<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Fulll\Domain\Model\Fleet;

readonly class DoctrineFleetRepository implements FleetRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function find(string $fleetId): ?Fleet
    {
        return $this->entityManager->find(Fleet::class, $fleetId);
    }

    public function add(Fleet $fleet): void
    {
        $this->entityManager->persist($fleet);
        $this->entityManager->flush();
    }

    public function update(Fleet $fleet): void
    {
        $this->entityManager->persist($fleet);
        $this->entityManager->flush();
    }
}
