<?php

namespace App\Cli\InfoParser;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DomCrawler\Crawler;

#[AsCommand(name: 'parse:start_parse_info')]
class InfoParserIndex extends Command
{

    //php bin/console parse:start_parse_info
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        //find forecasts
        $rawHtml = file_get_contents('https://pogoda.mail.ru/prognoz/yoshkar-ola/24hours/');

        $crawler = new Crawler($rawHtml);
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

        foreach ($todayForecast as $forecast) {
            $time = 'Время ' . $forecast['time'];
            $temp = 'Температура '. $forecast['tempe'];
            $tempComf = 'Ощущается как '. $forecast['tempe_comf'];
            $rainChance = 'Вероятность осадков '. $forecast['precip_prob'] . '%';
            print_r(implode('; ', [$time, $temp, $tempComf, $rainChance]). PHP_EOL);
        }
        
//        foreach ($forecasts as $forecast) {
//
//        }

//        foreach ($dates as $date) {
//            if (!isset($date['forecasts'])) {
//                //публичные ошибки
//                throw new \Exception('Данные по погоде на сегодня отсутствуют');
//            }
//        }
        return 1;
    }
}