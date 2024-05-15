<?php

namespace Fulll\Infra\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fulll\Domain\Model\VehicleInterface;
use Fulll\Domain\Model\FleetInterface;

#[ORM\Entity]
#[ORM\Table(name: "vehicles")]
class Vehicle implements VehicleInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string $plateNumber;

    #[ORM\ManyToOne(targetEntity: Fleet::class, inversedBy: "vehicles")]
    #[ORM\JoinColumn(name: "fleet_id", referencedColumnName: "id", nullable: true)]
    private ?FleetInterface $fleet = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $lastLatitude = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $lastLongitude = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $lastAltitude = null;

    public function __construct(string $plateNumber)
    {
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

    public function getLocation(): array
    {
        return [
            'latitude' => $this->lastLatitude,
            'longitude' => $this->lastLongitude,
            'altitude' => $this->lastAltitude,
        ];
    }
}
