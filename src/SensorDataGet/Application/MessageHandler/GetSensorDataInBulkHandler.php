<?php

declare(strict_types=1);


namespace App\SensorDataGet\Application\MessageHandler;
use App\Sensor\Domain\Entity\Sensor;
use App\Sensor\Domain\Repository\SensorRepository;
use App\SensorDataGet\Application\Message\GetSensorDataInBulk;
use App\SensorDataGet\Application\Message\GetSingleSensorData;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class GetSensorDataInBulkHandler
{
    public function __construct(
        private readonly SensorRepository $sensorRepository,
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(GetSensorDataInBulk $getSensorDataInBulk)
    {
        $activeSensors = $this->sensorRepository->findActiveTemperatureSensors();

        foreach ($activeSensors as $activeSensor) {
            if ($activeSensor instanceof Sensor) {
                $this->messageBus->dispatch(new GetSingleSensorData($activeSensor->getSensorIp()));
            }
        }
    }
}