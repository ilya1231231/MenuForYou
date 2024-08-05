<?php

namespace App\Modules\MailRuWeather\Application\DTO;

class ForecastByHourDto
{
    readonly public \DateTime $time;

    readonly public string $temp;

    readonly public string $temp_sense;

    readonly public int $rain_chance;

    public function __construct(array $data)
    {
        $this->time = $data['time'];
        $this->temp = $data['temp'];
        $this->temp_sense = $data['temp_sense'];
        $this->rain_chance = $data['rain_chance'];
    }

}