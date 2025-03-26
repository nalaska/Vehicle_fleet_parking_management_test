<?php
declare(strict_types=1);

use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Handler\CreateFleetHandler;
use Fulll\App\Handler\RegisterVehicleHandler;
use Fulll\App\Handler\ParkVehicleHandler;
use Fulll\Infra\Repository\InMemoryFleetRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;

class VehicleFleetContext implements Context
{
    private InMemoryFleetRepository $repository;
    private ?string $currentFleetId = null;
    private ?string $currentVehiclePlate = null;
    private ?array $tempLocation = null;
    private ?string $errorMessage = null;

    public function __construct()
    {
        $this->repository = new InMemoryFleetRepository();
    }

    #[Given("my fleet")]
    public function myFleet(): void
    {
        $handler = new CreateFleetHandler($this->repository);
        $fleet = $handler->handle(new CreateFleetCommand('current_user'));
        $this->currentFleetId = $fleet->getFleetId();
    }

    #[Given("the fleet of another user")]
    public function theFleetOfAnotherUser(): void
    {
        $handler = new CreateFleetHandler($this->repository);
        $fleet = $handler->handle(new CreateFleetCommand('another_user'));
        $this->currentFleetId = $fleet->getFleetId();
    }

    #[Given("a vehicle with plate number :plateNumber")]
    public function aVehicleWithPlateNumber(string $plateNumber): void
    {
        $this->currentVehiclePlate = $plateNumber;
    }

    #[Given("I have registered this vehicle into my fleet")]
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $handler = new RegisterVehicleHandler($this->repository);
        try {
            $handler->handle(new RegisterVehicleCommand($this->currentFleetId, $this->currentVehiclePlate));
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    #[When("I register this vehicle into my fleet")]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $handler = new RegisterVehicleHandler($this->repository);
        try {
            $handler->handle(new RegisterVehicleCommand($this->currentFleetId, $this->currentVehiclePlate));
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    #[Then("this vehicle should be part of my vehicle fleet")]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $fleet = $this->repository->find($this->currentFleetId);
        if (!$fleet || !$fleet->hasVehicle($this->currentVehiclePlate)) {
            throw new Exception("Vehicle is not registered in the fleet");
        }
    }

    /**
     * @throws Exception
     */
    #[Then("I should be informed that this vehicle has already been registered into my fleet")]
    public function iShouldBeInformedThatThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        if ($this->errorMessage !== "Vehicle already registered in this fleet") {
            throw new Exception("Expected error message not received");
        }
    }

    #[Given("a location with lat :lat and lng :lng")]
    public function aLocationWithLatAndLng(float $lat, float $lng): void
    {
        $this->tempLocation = ['lat' => $lat, 'lng' => $lng];
    }

    #[When("I park my vehicle at this location")]
    public function iParkMyVehicleAtThisLocation(): void
    {
        $handler = new ParkVehicleHandler($this->repository);
        try {
            $handler->handle(new ParkVehicleCommand(
                $this->currentFleetId,
                $this->currentVehiclePlate,
                $this->tempLocation['lat'],
                $this->tempLocation['lng']
            ));
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    #[Then("the known location of my vehicle should be :expectedLocation")]
    public function theKnownLocationOfMyVehicleShouldBe(string $expectedLocation): void
    {
        $fleet = $this->repository->find($this->currentFleetId);

        if ($fleet === null) {
            throw new Exception("Vehicle is not registered in the fleet");
        }

        $vehicle = $fleet->getVehicle($this->currentVehiclePlate);

        if ($vehicle === null) {
            throw new Exception("Vehicle is not registered in the fleet");
        }

        $location = $vehicle->getCurrentLocation();

        if ($location === null) {
            throw new Exception("Vehicle is not registered in the fleet");
        }

        $actualLocation = $location->lat . ',' . $location->lng;
        if ($actualLocation !== $expectedLocation) {
            throw new Exception("Expected location $expectedLocation, got $actualLocation");
        }
    }

    /**
     * @throws Exception
     */
    #[Then("I should be informed that my vehicle is already parked at this location")]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if ($this->errorMessage !== "Vehicle already parked at this location") {
            throw new Exception("Expected parking error message not received");
        }
    }

    #[Given("my vehicle has been parked into this location")]
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        throw new PendingException();
    }

    #[When("I try to park my vehicle at this location")]
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        throw new PendingException();
    }

    #[When("I try to register this vehicle into my fleet")]
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        throw new PendingException();
    }

    #[Given("this vehicle has been registered into the other user's fleet")]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet(): void
    {
        throw new PendingException();
    }
}
