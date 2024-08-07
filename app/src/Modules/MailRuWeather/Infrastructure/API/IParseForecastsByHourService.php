<?php

namespace App\Modules\MailRuWeather\Infrastructure\API;

interface IParseForecastsByHourService
{
    public function saveResults(array $dtoArray): void;

}