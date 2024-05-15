<?php

namespace Fulll\App\Command\Vehicle;

/**
 * Class LocalizeVehicleCommand
 * This command is used to localize a vehicle in a fleet.
 */
final class LocalizeVehicleCommand
{
    private int $fleetId;
    private string $plateNumber;
    private float $latitude;
    private float $longitude;
    private float $altitude;

    public function __construct(int $fleetId, string $plateNumber, float $latitude, float $longitude, float $altitude = 0.0)
    {
        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    public function getFleetId(): int
    {
        return $this->fleetId;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAltitude(): float
    {
        return $this->altitude;
    }
}
