<?php

namespace Fulll\Domain\Model;

interface FleetInterface
{
    public function getId(): ?int;
    public function getUserId(): string;
    public function setUserId(string $userId): void;
    public function addVehicle(VehicleInterface $vehicle): void;
    public function hasVehicle(VehicleInterface $vehicle): bool;
    /**
     * @return VehicleInterface[]
     */
    public function getVehicles(): array;
    public function parkVehicle(VehicleInterface $vehicle, float $latitude, float $longitude, float $altitude = 0.0): void;
    /**
     * @return array<string, float|null>
     */
    public function getVehicleLocation(VehicleInterface $vehicle): ?array;
}
