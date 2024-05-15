<?php

namespace Fulll\App\Command\Fleet;

use Fulll\Infra\Entity\Fleet;
use Doctrine\ORM\EntityManagerInterface;

final class CreateFleetHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(CreateFleetCommand $command): void
    {
        $fleet = new Fleet($command->getUserId());

        $this->entityManager->persist($fleet);
        $this->entityManager->flush();
    }
}
