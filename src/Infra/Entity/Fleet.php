<?php

namespace Fulll\Infra\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Fulll\Domain\Model\FleetInterface;
use Fulll\Domain\Model\VehicleInterface;
use Fulll\Infra\Entity\Vehicle;

#[ORM\Entity]
#[ORM\Table(name: "fleets")]
class Fleet implements FleetInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string")]
    private string $userId;
    /** @var Collection<int, Vehicle> */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: "fleet", cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $vehicles;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
        $this->vehicles = new ArrayCollection();
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
        // Ensure the $vehicle is of type Vehicle
        if (!$vehicle instanceof Vehicle) {
            throw new \InvalidArgumentException("Expected instance of Vehicle");
        }

        if ($this->vehicles->contains($vehicle)) {
            throw new \Exception("Vehicle already registered in the fleet.");
        }
        $this->vehicles->add($vehicle);
        $vehicle->setFleet($this);
    }

    public function hasVehicle(VehicleInterface $vehicle): bool
    {
        return $this->vehicles->contains($vehicle);
    }

    public function getVehicles(): array
    {
        return $this->vehicles->toArray();
    }

    public function parkVehicle(VehicleInterface $vehicle, float $latitude, float $longitude, float $altitude = 0.0): void
    {
        if ($vehicle->isSameLocation($latitude, $longitude)) {
            throw new \Exception("Vehicle is already parked at this location.");
        }
        $vehicle->updateLocation($latitude, $longitude, $altitude);
    }

    public function getVehicleLocation(VehicleInterface $vehicle): ?array
    {
        if ($this->hasVehicle($vehicle)) {
            return $vehicle->getLocation();
        }
        return null;
    }
}
