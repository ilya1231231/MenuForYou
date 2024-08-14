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

        $forecastsByDay = array_map(static fn($dates) => $dates['forecasts'] ?? [], $dates);

        $todayForecast = !empty($forecastsByDay[0]) ? $forecastsByDay[0] : [];
        $tomorrowForecast = !empty($forecastsByDay[1]) ? $forecastsByDay[1] : [];
        $todayForecastsByHour = $this->prepareByHourForecastsOfDay($todayForecast);
        $tomorrowForecastsByHour = $this->prepareByHourForecastsOfDay($tomorrowForecast);

        return new ForecastByDaysDto($todayForecastsByHour, $tomorrowForecastsByHour);
    }

    private function getRainType(string $description): ?string
    {
        if(!str_contains($description, 'дождь')) {
            return null;
        }

        $explodedDescription = explode(',', $description);
        $rawRainType = $explodedDescription[1];

        return trim($rawRainType);
    }

    /**
     * @return ForecastByHourDto[]
     * */
    private function prepareByHourForecastsOfDay(array $rawByHourForecastsOfDay): ?array
    {
        if (!$rawByHourForecastsOfDay) {
//            @todo залогировтаь
            return null;
        }

        $byHourForecastsOfDay = [];
        foreach ($rawByHourForecastsOfDay as $forecast) {
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
            $rainType = $this->getRainType($forecast['description']);

            $data = [
                'time' => $datetime->setTime($hour, $minutes),
                'temp' => $forecast['tempe'],
                'temp_sense' => $forecast['tempe_comf'],
                'rain_chance' => $forecast['precip_prob'],
                'rain_type' => $rainType,
            ];
            $forecastForHourDto = new ForecastByHourDto($data);

            $byHourForecastsOfDay[] = $forecastForHourDto;
        }

        return $byHourForecastsOfDay;
    }
}