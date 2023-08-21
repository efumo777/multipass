<?php

declare(strict_types=1);


namespace App\SensorDataPost\Domain\Model;

class ReadingModel
{
    private string $sensor_uuid;

    private float $temperature;


    public function getSensorUuid(): string
    {
        return $this->sensor_uuid;
    }

    public function setSensorUuid(string $sensor_uuid): void
    {
        $this->sensor_uuid = $sensor_uuid;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }
}