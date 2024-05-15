<?php

namespace Fulll\Domain\Model;

interface VehicleInterface
{
    public function getId(): ?int;
    public function getPlateNumber(): string;
    public function setFleet(?FleetInterface $fleet): void;
    public function getFleet(): ?FleetInterface;
    public function updateLocation(float $latitude, float $longitude, float $altitude = 0.0): void;
    public function isSameLocation(float $latitude, float $longitude): bool;
    /**
     * @return array<string, float|null>
    */
    public function getLocation(): array;
}
