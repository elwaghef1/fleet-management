<?php

use Behat\Behat\Context\Context;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Repository\InMemoryFleetRepository;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{
    private InMemoryFleetRepository $fleetRepository;
    private ?Fleet $fleet = null;
    private ?Vehicle $vehicle = null;
    private ?Location $location = null;
    private ?Fleet $anotherFleet = null;
    private ?\Exception $exception = null;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $id = intval('my_fleet');
        $userId = 'user32';
        $vehicles = [];

        $this->fleet = new Fleet($id, $userId, $vehicles);
        $this->fleetRepository->save($this->fleet);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $id = intval('vehicle_1');
        $plateNumber = 'GH123GE';
        $this->vehicle = new Vehicle($id, $plateNumber);
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        // Set a default location for the vehicle
        $this->vehicle->updateLocation(35.0522, -119.2437, 17.0);
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $this->fleet->addVehicle($this->vehicle);
        $this->fleetRepository->save($this->fleet);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        Assert::assertTrue($this->fleet->hasVehicle($this->vehicle));
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->iRegisterThisVehicleIntoMyFleet();
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        try {
            $this->iRegisterThisVehicleIntoMyFleet();
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then I should be informed that this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThatThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        Assert::assertEquals("Vehicle already registered in the fleet.", $this->exception->getMessage());
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $id = intval('another_fleet');
        $userId = 'user32';
        $vehicles = [];

        $this->anotherFleet = new Fleet($id, $userId, $vehicles);
        $this->fleetRepository->save($this->anotherFleet);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $this->anotherFleet->addVehicle($this->vehicle);
        $this->fleetRepository->save($this->anotherFleet);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $this->vehicle->updateLocation(35.0522, -119.2437, 17.0);
        $this->fleetRepository->save($this->fleet);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        $location = $this->vehicle->getLocation();
        Assert::assertEquals(['latitude' => 35.0522, 'longitude' => -119.2437, 'altitude' => 17.0], $location);
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->iParkMyVehicleAtThisLocation();
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        try {
            $this->iParkMyVehicleAtThisLocation();
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        Assert::assertNotNull($this->exception);
        Assert::assertEquals("Vehicle is already parked at this location.", $this->exception->getMessage());
    }
}
