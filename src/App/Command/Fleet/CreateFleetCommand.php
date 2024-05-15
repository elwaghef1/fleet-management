<?php

namespace Fulll\App\Command\Fleet;

/**
 * Class CreateFleetCommand
 * This command is used to create a new fleet.
 */
final class CreateFleetCommand
{
    private string $userId;

    /**
     * CreateFleetCommand constructor.
     * @param string $userId The ID of the user who owns the fleet.
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Gets the user ID associated with the new fleet.
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
