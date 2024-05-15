<?php

namespace Fulll\App\Query\Fleet;

final class GetFleetQuery
{
    private int $fleetId;

    public function __construct(int $fleetId)
    {
        $this->fleetId = $fleetId;
    }

    public function getFleetId(): int
    {
        return $this->fleetId;
    }
}
