<?php

namespace Fulll\Domain\Model;

class Vehicle implements VehicleInterface
{
    private ?int $id;
    private string $plateNumber;
    private ?FleetInterface $fleet = null;
    private ?float $lastLatitude = null;
    private ?float $lastLongitude = null;
    private ?float $lastAltitude = null;

    public function __construct(?int $id, string $plateNumber)
    {
        $this->id = $id;
        $this->plateNumber = $plateNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function setFleet(?FleetInterface $fleet): void
    {
        $this->fleet = $fleet;
    }

    public function getFleet(): ?FleetInterface
    {
        return $this->fleet;
    }

    public function updateLocation(float $latitude, float $longitude, float $altitude = 0.0): void
    {
        $this->lastLatitude = $latitude;
        $this->lastLongitude = $longitude;
        $this->lastAltitude = $altitude;
    }

    public function isSameLocation(float $latitude, float $longitude): bool
    {
        return $this->lastLatitude === $latitude && $this->lastLongitude === $longitude;
    }

    /**
     * @return array<string, float|null>
     */
    public function getLocation(): array
    {
        return [
            'latitude' => $this->lastLatitude,
            'longitude' => $this->lastLongitude,
            'altitude' => $this->lastAltitude,
        ];
    }
}
