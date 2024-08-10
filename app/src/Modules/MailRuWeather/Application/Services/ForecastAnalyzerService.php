<?php

namespace App\Modules\MailRuWeather\Application\Services;

use App\Modules\MailRuWeather\Application\DTO\ForecastByHourDto;

class ForecastAnalyzerService
{
    /**
     * @param $dtoArray ForecastByHourDto[]
     * */
    public function getDailyForecast(array $dtoArray): string
    {
        //@todo перенести в сервиси анализатор
        return '';
    }
}