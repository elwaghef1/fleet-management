<?php

namespace Fulll\Infra\Command;

use Fulll\App\Command\Vehicle\RegisterVehicleCommand as RegisterVehicleAppCommand;
use Fulll\App\Command\Vehicle\RegisterVehicleHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(
    name: 'app:register-vehicle',
    description: 'Registers a new vehicle to a specified fleet.',
    hidden: false
)]
class RegisterVehicleCommand extends Command
{
    private RegisterVehicleHandler $registerVehicleHandler;

    public function __construct(RegisterVehicleHandler $registerVehicleHandler)
    {
        parent::__construct();
        $this->registerVehicleHandler = $registerVehicleHandler;
    }

    protected function configure(): void
    {
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'The ID of the fleet to which the vehicle will be registered.');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'The plate number of the vehicle to register.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var int $fleetId */
        $fleetId = $input->getArgument('fleetId');
        /** @var string $plateNumber */
        $plateNumber = $input->getArgument('vehiclePlateNumber');
        try {
            // Create the command object
            $command = new RegisterVehicleAppCommand($fleetId, $plateNumber);
            
            // Delegate the task of registering the vehicle to the handler
            $this->registerVehicleHandler->handle($command);
            $output->writeln("Vehicle with plate number $plateNumber has been successfully registered to fleet ID $fleetId.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
