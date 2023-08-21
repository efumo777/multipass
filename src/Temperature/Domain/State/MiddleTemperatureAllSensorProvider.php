<?php

declare(strict_types=1);

namespace App\Temperature\Domain\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Temperature\Domain\Repository\TemperatureRepository;

class MiddleTemperatureAllSensorProvider implements ProviderInterface
{
    public function __construct(
        private readonly TemperatureRepository $temperatureRepository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null|object
    {
        if (array_key_exists('filters', $context) && array_key_exists('createdAt', $context['filters']) && array_key_exists('between', $context['filters']['createdAt'])) {
            $dateRange = explode('-', $context['filters']['createdAt']['between']);
            if (2 === count($dateRange)) {
                return $this->temperatureRepository->calculateAverageTemperature($dateRange[0], $dateRange[1]);
            }
        }

        return null;
    }
}
