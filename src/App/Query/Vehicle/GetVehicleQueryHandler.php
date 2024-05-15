<?php

namespace Fulll\App\Query\Vehicle;

use Doctrine\ORM\EntityManagerInterface;
use Fulll\Infra\Entity\Vehicle;

final class GetVehicleQueryHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(GetVehicleQuery $query): ?Vehicle
    {
        return $this->entityManager->getRepository(Vehicle::class)->findOneBy(['plateNumber' => $query->getPlateNumber()]);
    }
}