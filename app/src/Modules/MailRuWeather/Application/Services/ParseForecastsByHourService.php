<?php

namespace App\Modules\MailRuWeather\Application\Services;

use App\Modules\MailRuWeather\Application\DTO\ForecastByHourDto;
use App\Modules\MailRuWeather\Infrastructure\API\IParseForecastsByHourService;

class ParseForecastsByHourService implements IParseForecastsByHourService
{
    /**
     * @param ForecastByHourDto[] $dtoArray
     */
    public function saveResults(array $dtoArray): void
    {

    }
}