<?php

namespace App\Modules\MailRuWeather\Application\DTO;

class ForecastByDaysDto
{
    /** @var ForecastByHourDto[]* */
    public readonly array $currentDayForecasts;

    /** @var ForecastByHourDto[]* */
    public readonly ?array $tomorrowDayForecasts;

    /**
     * @param ForecastByHourDto[] $currentDayForecasts
     * @param ForecastByHourDto[] $tomorrowDayForecasts
     * */
    public function __construct(array $currentDayForecasts, ?array $tomorrowDayForecasts)
    {
        $this->currentDayForecasts = $currentDayForecasts;
        $this->tomorrowDayForecasts = $tomorrowDayForecasts;
    }
}