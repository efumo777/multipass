<?php

declare(strict_types=1);


namespace App\Temperature\Infrastructure\DTO;

use App\SensorDataPost\Domain\Model\ReadingModel;
use App\Shared\Application\Service\ConvertationFahrenheitToCelsiusService;
use App\Temperature\Domain\Entity\Temperature;

class TemperatureDTO
{
    public function createFromCSVString($csvString): ?Temperature
    {
        $dataArray = str_getcsv($csvString);
        if (2 != count($dataArray)) {
            return null;
        }

        $temperature = new Temperature();
        $temperature->setTemperatureCelsius($dataArray[1]);

        return $temperature;
    }

    public function createFromReadingModel(ReadingModel $readingModel): ? Temperature
    {
        $temperature = new Temperature();
        $temperature->setTemperatureCelsius((new ConvertationFahrenheitToCelsiusService())->convertFahrenheitToCelsius($readingModel->getTemperature()));
        $temperature->setSensorUuid($readingModel->getSensorUuid());

        return $temperature;
    }
}