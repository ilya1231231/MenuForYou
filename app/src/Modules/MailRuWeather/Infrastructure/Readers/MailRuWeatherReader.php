<?php

namespace App\Modules\MailRuWeather\Infrastructure\Readers;

use App\Modules\MailRuWeather\Application\DTO\ForecastByHourDto;
use DateTime;
use Symfony\Component\DomCrawler\Crawler;

class MailRuWeatherReader
{
    /**
     * @return ForecastByHourDto[]
     *
     * @throws \Exception
     */
    public function readRawHtml(string $html): array
    {
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('div[data-module="ForecastHour"]');

        if (!$crawler->count()) {
            throw new \Exception('Нужно переделывать парсинг. Не найдено элементов');
        }

        if ($crawler->count() > 1) {
            throw new \Exception('Нужно переделывать парсинг. Найдено несколко элементов');
        }

        $rawJson = $crawler->attr('onclick');
        $json = trim(str_replace('return', '', $rawJson));

        $data = json_decode($json, true);

        if (!isset($data['ForecastHour']['data']['dates'])) {
            throw new \Exception('Нужно переделывать парсинг. Нет данных о погоде в json');
        }

        $dates = $data['ForecastHour']['data']['dates'];
        if (!$dates && !is_array($dates)) {
            throw new \Exception('Нужно переделывать парсинг. Проблема c датами');
        }

        if (empty($dates['forecasts']) && !is_array($dates['forecasts'])) {
            throw new \Exception('Нужно переделывать парсинг. Не найдены прогнозы');
        }

        $byHourForecastDtoArray = [];
        $forecasts = $dates['forecasts'];
        foreach ($forecasts as $forecastByHour) {
            $isForecastInvalid =
                empty($forecastByHour['time'])
                || empty($forecastByHour['tempe'])
                || empty($forecastByHour['tempe_comf'])
                || empty($forecastByHour['precip_prob']);
            if ($isForecastInvalid) {
                continue;
            }

            $explodedTime = explode(':', $forecastByHour['time']);
            $hour = $explodedTime[0];
            $minutes = $explodedTime[1];
            $datetime = new DateTime();
            $datetime = $datetime->setTime($hour, $minutes);

            $byHourForecastDtoArray[] = new ForecastByHourDto([
                'time' => $datetime,
                'temp' => $forecastByHour['tempe'],
                'temp_sense' => $forecastByHour['tempe_comf'],
                'rain_chance' => $forecastByHour['precip_prob'],
            ]);
        }

        return $byHourForecastDtoArray;
    }
}