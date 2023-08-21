<?php

declare(strict_types=1);


namespace App\SensorDataGet\Application\Message;

class GetSingleSensorData
{
    public function __construct(
        private readonly string $sensorIp,
    ) {
    }

    public function getSensorIp(): string
    {
        return $this->sensorIp;
    }

    public function setSensorIp(string $sensorIp): void
    {
        $this->sensorIp = $sensorIp;
    }
}