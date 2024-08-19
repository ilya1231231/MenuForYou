<?php

namespace App\Modules\MailRuWeather\Infrastructure\Dbal\Repository;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\HourlyMailRuWeather;

interface IHourlyMailRuWeatherRepository
{
    public function save(HourlyMailRuWeather $hourlyMailRuWeather): int;
}