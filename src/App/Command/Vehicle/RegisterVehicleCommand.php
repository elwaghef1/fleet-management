<?php

namespace Fulll\App\Command\Vehicle;

/**
 * Class RegisterVehicleCommand
 * This command is used to register a new vehicle into a fleet.
 */
final class RegisterVehicleCommand
{
    private int $fleetId;
    private string $plateNumber;

    /**
     * RegisterVehicleCommand constructor.
     * @param int $fleetId The ID of the fleet to which the vehicle will be added.
     * @param string $plateNumber The plate number of the vehicle to register.
     */
    public function __construct(int $fleetId, string $plateNumber)
    {
        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
    }

    /**
     * Gets the fleet ID.
     * @return int
     */
    public function getFleetId(): int
    {
        return $this->fleetId;
    }

    /**
     * Gets the plate number of the vehicle.
     * @return string
     */
    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }
}
