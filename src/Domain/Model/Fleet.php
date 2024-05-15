<?php

namespace Fulll\Domain\Model;

class Fleet implements FleetInterface
{
    private ?int $id;
    private string $userId;
    /**
     *  @var array<string, VehicleInterface> 
     *  @return VehicleInterface[]
     * */
    private array $vehicles = [];

    public function __construct(?int $id, string $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function addVehicle(VehicleInterface $vehicle): void
    {
        if (isset($this->vehicles[$vehicle->getPlateNumber()])) {
            throw new \Exception("Vehicle already registered in the fleet.");
        }
        $this->vehicles[$vehicle->getPlateNumber()] = $vehicle;
    }

    public function hasVehicle(VehicleInterface $vehicle): bool
    {
        return isset($this->vehicles[$vehicle->getPlateNumber()]);
    }

    /**
     * @return VehicleInterface[]
     */
    public function getVehicles(): array
    {
        return array_values($this->vehicles);
    }

    public function parkVehicle(VehicleInterface $vehicle, float $latitude, float $longitude, float $altitude = 0.0): void
    {
        if ($vehicle->isSameLocation($latitude, $longitude)) {
            throw new \Exception("Vehicle is already parked at this location.");
        }
        $vehicle->updateLocation($latitude, $longitude, $altitude);
    }

    /**
     * @return array<string, float|null>
     */
    public function getVehicleLocation(VehicleInterface $vehicle): ?array
    {
        if ($this->hasVehicle($vehicle)) {
            return $vehicle->getLocation();
        }
        return null;
    }
}
