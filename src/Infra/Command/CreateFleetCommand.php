<?php

namespace Fulll\Infra\Command;

use Fulll\App\Command\Fleet\CreateFleetCommand as CreateFleetAppCommand;
use Fulll\App\Command\Fleet\CreateFleetHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'app:create-fleet')]
class CreateFleetCommand extends Command
{
    private CreateFleetHandler $createFleetHandler;

    /**
     * Constructor injection for dependency management.
     *
     * @param CreateFleetHandler $createFleetHandler The handler that manages fleet creation logic.
     */
    public function __construct(CreateFleetHandler $createFleetHandler)
    {
        parent::__construct();
        $this->createFleetHandler = $createFleetHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new fleet with a given userId.')
            ->setHelp('This command allows you to create a fleet')
            ->addArgument('userId', InputArgument::REQUIRED, 'The ID of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**
        * @var string|null $userId
        */
        $userId = $input->getArgument('userId');
        $command = new CreateFleetAppCommand((string)$userId);

        // Delegate the task of creating the fleet to the handler
        $this->createFleetHandler->handle($command);

        $output->writeln('Fleet created for user ID: ' . $userId);

        return Command::SUCCESS;
    }
}
