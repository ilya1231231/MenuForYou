<?php

namespace App\Modules\MailRuWeather\Application\DTO;

class ForecastByHourDto
{
    readonly public \DateTime $datetime;

    readonly public string $temp;

    readonly public string $temp_sense;

    readonly public int $rain_chance;

    readonly public string $description;

    public function __construct(array $data)
    {
        $this->datetime = $data['time'];
        $this->temp = $data['temp'];
        $this->temp_sense = $data['temp_sense'];
        $this->rain_chance = $data['rain_chance'];
        $this->description = $data['description'];
    }

}