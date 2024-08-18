<?php

namespace App\Modules\MailRuWeather\Application\Services;

use App\Modules\MailRuWeather\Application\DTO\ForecastByHourDto;

class ForecastAnalyzerService
{
    /**
     * @param $forecastsByHourDtoArray ForecastByHourDto[]
     * */
    public function getRainForecastByDay(array $forecastsByHourDtoArray): string
    {
        $highRainChanceForecasts = array_filter(
            $forecastsByHourDtoArray,
            static fn(ForecastByHourDto $el) => $el->rain_chance > 50
        );

        if (!$highRainChanceForecasts) {
            return 'Дождя не ожидается';
        }

        $everyHourRainChunks = [];
        foreach ($highRainChanceForecasts as $forecast) {
            if (!$everyHourRainChunks) {
                $everyHourRainChunks[][] = $forecast;
                continue;
            }

            $chunkKey = array_key_last($everyHourRainChunks);
            $lastForecastOfChunk = end($everyHourRainChunks[$chunkKey]);
            $datetimeDiff = $forecast->datetime->diff($lastForecastOfChunk->datetime);
            if ($datetimeDiff->h > 1) {
                $everyHourRainChunks[][] = $forecast;
                continue;
            }

            $everyHourRainChunks[$chunkKey][] = $forecast;
        }

        $rainForecast = '<b>Прогноз по осадкам</b> ';
        foreach ($everyHourRainChunks as $chunk) {
            $array = array_values($chunk);
            $rainBeginForecast = array_shift($array);
            if (count($chunk) === 1) {
                $rainForecast = $rainForecast . $this->buildSingleHourRainForecast($rainBeginForecast);
                continue;
            }

            $rainEndForecast = end($chunk);
            $timeBegin = $rainBeginForecast->datetime->format('G:i');
            $timeEnd = $rainEndForecast->datetime->format('G:i');
            $forecast = 'C ' . $timeBegin . ' до ' . $timeEnd . '. ';
            $rainForecast = $rainForecast . $forecast;
        }

        return $rainForecast;
    }

    private function buildSingleHourRainForecast(ForecastByHourDto $rainBeginForecast): string
    {
        return "\xE2\x98\x94 \n"
            . $rainBeginForecast->rain_type
            . ' в ' . $rainBeginForecast->datetime->format('G:i') . '.';
    }

    /**
     * @param ForecastByHourDto[] $chunk
     * */
    private function buildMultipleHoursRainForecast(array $chunk): string
    {
        //@todo доделать
        return '';
    }
}