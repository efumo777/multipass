<?php

declare(strict_types=1);


namespace App\SensorDataGet\Infrastructure\Command;

use App\SensorDataGet\Application\Message\GetSensorDataInBulk;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:read-all-temperature-sensors-data',
    description: 'Read all active sensors data',
    aliases: ['app:read-temp-sensors-data'],
    hidden: false,
)]
class SensorDataGetCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->messageBus->dispatch(new GetSensorDataInBulk());

        return Command::SUCCESS;
    }

}