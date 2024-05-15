<?php

namespace Fulll\App\Command\Vehicle;

use Fulll\App\Query\Fleet\GetFleetQuery;
use Fulll\App\Query\Fleet\GetFleetQueryHandler;
use Fulll\App\Query\Vehicle\GetVehicleQuery;
use Fulll\App\Query\Vehicle\GetVehicleQueryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Fulll\Infra\Entity\Vehicle;

final class RegisterVehicleHandler
{
    private EntityManagerInterface $entityManager;
    private GetVehicleQueryHandler $vehicleQueryHandler;
    private GetFleetQueryHandler $fleetQueryHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        GetVehicleQueryHandler $vehicleQueryHandler,
        GetFleetQueryHandler $fleetQueryHandler
    ) {
        $this->entityManager = $entityManager;
        $this->vehicleQueryHandler = $vehicleQueryHandler;
        $this->fleetQueryHandler = $fleetQueryHandler;
    }

    public function handle(RegisterVehicleCommand $command): void
    {
        $fleet = $this->fleetQueryHandler->handle(new GetFleetQuery($command->getFleetId()));
        $existingVehicle = $this->vehicleQueryHandler->handle(new GetVehicleQuery($command->getPlateNumber()));
        if ($existingVehicle) {
            throw new \Exception("Vehicle already registered with plate number: " . $command->getPlateNumber());
        }

        $vehicle = new Vehicle($command->getPlateNumber());
        $vehicle->setFleet($fleet);
        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    }
}
