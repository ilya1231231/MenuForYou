<?php

namespace App\Modules\MailRuWeather\Application\Services;

use App\Modules\MailRuWeather\Application\DTO\ForecastByDaysDto;
use App\Modules\MailRuWeather\Application\DTO\ForecastByHourDto;
use DateTime;

class ParseForecastsService
{
    public function parseForecastsJson(string $json): ForecastByDaysDto
    {
        $data = json_decode($json, true);

        if (!isset($data['ForecastHour']['data']['dates'])) {
            throw new \Exception('Нужно переделывать парсинг. Нет данных о погоде в json');
        }

        $dates = $data['ForecastHour']['data']['dates'];
        if (!is_array($dates)) {
            throw new \Exception('Нужно переделывать парсинг. Проблема в структуре данных');
        }

        if (!$dates) {
            throw new \Exception('Нужно переделывать парсинг. Нет данных по датам');
        }

        $forecasts = array_map(static fn($dates) => $dates['forecasts'] ?? [], $dates);

        $todayForecast = $forecasts[0];
        if (!$todayForecast) {
            throw new \Exception('Нет данных по прогнозу на сегодня');
        }

        $todayForecastsByHour = [];
        foreach ($todayForecast as $forecast) {
            $isForecastDataExist =
                !empty($forecast['time'])
                && !empty($forecast['tempe'])
                && !empty($forecast['tempe_comf'])
                && !empty($forecast['precip_prob'])
                && !empty($forecast['description']);

            if (!$isForecastDataExist) {
                //@todo залогировать
                continue;
            }

            $datetime = new DateTime();
            $explodedTime = explode(':', $forecast['time']);
            $hour = $explodedTime[0];
            $minutes = $explodedTime[1];

            $data = [
                'time' => $datetime->setTime($hour, $minutes),
                'temp' => $forecast['tempe'],
                'temp_sense' => $forecast['tempe_comf'],
                'rain_chance' => $forecast['precip_prob'],
                'description' => $forecast['description'],
            ];
            $forecastForHourDto = new ForecastByHourDto($data);

            $todayForecastsByHour[] = $forecastForHourDto;
        }

        return new ForecastByDaysDto($todayForecastsByHour, null);
    }

}