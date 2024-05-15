<?php

namespace Fulll\App\Command\Vehicle;

use Fulll\App\Query\Fleet\GetFleetQuery;
use Fulll\App\Query\Vehicle\GetVehicleQuery;
use Fulll\App\Query\Vehicle\GetVehicleQueryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Fulll\Infra\Entity\Vehicle;

final class LocalizeVehicleHandler
{
    private EntityManagerInterface $entityManager;
    private GetVehicleQueryHandler $vehicleQueryHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        GetVehicleQueryHandler $vehicleQueryHandler,
    ) {
        $this->entityManager = $entityManager;
        $this->vehicleQueryHandler = $vehicleQueryHandler;
    }

    public function handle(LocalizeVehicleCommand $command): void
    {
        $vehicle = $this->vehicleQueryHandler->handle(new GetVehicleQuery($command->getPlateNumber()));
        if (!$vehicle) {
            throw new \Exception("No vehicle found with plate number: " . $command->getPlateNumber());
        }

        // Check if the last known location is the same as the new location
        if ($vehicle->isSameLocation($command->getLatitude(), $command->getLongitude())) {
            throw new \Exception("Vehicle is already parked at this location.");
        }

        // Update the vehicle location
        $vehicle->updateLocation($command->getLatitude(), $command->getLongitude(), $command->getAltitude());
        $this->entityManager->flush();
    }
}
