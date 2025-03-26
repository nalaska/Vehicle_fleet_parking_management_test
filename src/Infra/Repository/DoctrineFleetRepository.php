<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Fulll\Domain\Model\Fleet;

class DoctrineFleetRepository implements FleetRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
