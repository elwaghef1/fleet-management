<?php

namespace Fulll\Infra\Command;

use Fulll\App\Command\Vehicle\LocalizeVehicleCommand as LocalizeVehicleAppCommand;
use Fulll\App\Command\Vehicle\LocalizeVehicleHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(
    name: 'app:localize-vehicle',
    description: 'Localizes a vehicle within a fleet.',
    hidden: false
)]
class LocalizeVehicleCommand extends Command
{
    private LocalizeVehicleHandler $localizeVehicleHandler;

    // Inject the handler responsible for the vehicle localization
    public function __construct(LocalizeVehicleHandler $localizeVehicleHandler)
    {
        parent::__construct();
        $this->localizeVehicleHandler = $localizeVehicleHandler;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('fleetId', InputArgument::REQUIRED, 'The ID of the fleet.')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'The plate number of the vehicle.')
            ->addArgument('lat', InputArgument::REQUIRED, 'Latitude of the vehicle\'s location.')
            ->addArgument('lng', InputArgument::REQUIRED, 'Longitude of the vehicle\'s location.')
            ->addArgument('alt', InputArgument::OPTIONAL, 'Altitude of the vehicle\'s location.', '0');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var int $fleetId */
        $fleetId = $input->getArgument('fleetId');
        /** @var string $plateNumber */
        $plateNumber = $input->getArgument('vehiclePlateNumber');
        /** @var float $latitude */
        $latitude = $input->getArgument('lat');
        /** @var float $longitude */
        $longitude = $input->getArgument('lng');
        /** @var float $altitude */
        $altitude = $input->getArgument('alt');

        try {
            // Create the command object
            $command = new LocalizeVehicleAppCommand($fleetId, $plateNumber, $latitude, $longitude, $altitude);

            // Delegate the task of localizing the vehicle to the handler
            $this->localizeVehicleHandler->handle($command);
            $output->writeln("Vehicle with plate number $plateNumber has been successfully localized at latitude $latitude, longitude $longitude" . ($altitude ? ", altitude $altitude" : "") . ".");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
