<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Model\FleetInterface;

interface FleetRepositoryInterface
{
    public function save(FleetInterface $fleet): void;
    public function findById(string $id): ?FleetInterface;
}
