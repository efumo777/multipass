<?php

declare(strict_types=1);


namespace App\Shared\Application\Service;

use phpDocumentor\Reflection\PseudoTypes\FloatValue;

class ConvertationFahrenheitToCelsiusService
{
    public function convertFahrenheitToCelsius(float $fahrenheitValue): float
    {
        return ($fahrenheitValue - 32) * (5/9);
    }
}