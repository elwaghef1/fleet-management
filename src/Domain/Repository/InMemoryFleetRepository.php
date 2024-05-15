<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Model\FleetInterface;
use Fulll\Domain\Repository\FleetRepositoryInterface;

class InMemoryFleetRepository implements FleetRepositoryInterface
{
    /**
     *  @var array<FleetInterface> 
     *  @return FleetInterface[]
     * */
    private array $fleets = [];

    public function save(FleetInterface $fleet): void
    {
        $this->fleets[$fleet->getId()] = $fleet;
    }

    public function findById(string $id): ?FleetInterface
    {
        return $this->fleets[$id] ?? null;
    }
}
