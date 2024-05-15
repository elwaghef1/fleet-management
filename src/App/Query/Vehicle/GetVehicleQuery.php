<?php

namespace Fulll\App\Query\Vehicle;

/**
 * Class GetVehicleQuery
 * This query retrieves a vehicle by its plate number or ID.
 */
final class GetVehicleQuery
{
    private string $plateNumber;

    public function __construct(string $plateNumber)
    {
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }
}
