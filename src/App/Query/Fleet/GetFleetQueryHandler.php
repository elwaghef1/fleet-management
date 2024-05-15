<?php

namespace Fulll\App\Query\Fleet;

use Doctrine\ORM\EntityManagerInterface;
use Fulll\Infra\Entity\Fleet;
use Doctrine\ORM\EntityNotFoundException;

final class GetFleetQueryHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(GetFleetQuery $query): Fleet
    {
        $fleet = $this->entityManager->getRepository(Fleet::class)->find($query->getFleetId());
        if (!$fleet) {
            throw new EntityNotFoundException("Fleet not found with ID: " . $query->getFleetId());
        }

        return $fleet;
    }
}
