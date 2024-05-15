# fleet-parking-management

Vehicle Fleet Management
This project provides a simple application to manage a fleet of vehicles and their locations. It uses Symfony for the CLI commands and Behat for testing.

Installation
Clone the repository:

git clone https://github.com/elwaghef1/fleet-parking-management.git
cd your-repo
Install dependencies:

- composer install
To run the Behat tests, use the following command:
- vendor/behat/behat/bin/behat

Run Behat tests: 
- vendor/behat/behat/bin/behat
- 
CLI Commands
The application provides several CLI commands to manage fleets and vehicles.

To create a new fleet, use the following command:
 - php bin/console create <userId>
Example: php bin/console create 12345

Register a Vehicle
To register a vehicle in a fleet, use the following command:

- php bin/console register-vehicle <fleetId> <vehiclePlateNumber>
Example: php bin/console register-vehicle 1 ABC123

Localize a Vehicle

To localize a vehicle in a fleet, use the following command:
- php bin/console localize-vehicle <fleetId> <vehiclePlateNumber> <lat> <lng> [alt]
Example: php bin/console localize-vehicle 1 ABC123 34.0522 -118.2437

To run phpStan: 
- vendor/bin/phpstan analyse
