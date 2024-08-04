<?php

namespace App\Cli\InfoParser;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\MailRuWeather;
use App\Modules\MailRuWeather\Infrastructure\Dbal\Repository\MailRuWeatherRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DomCrawler\Crawler;

#[AsCommand(name: 'parse:start_parse_info')]
class InfoParserIndex extends Command
{

    public function __construct(
        private MailRuWeatherRepository $mailRuWeatherRepository
    ){
        parent::__construct();
    }

    //php bin/console parse:start_parse_info
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->testSave();
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
            if (!isset($forecast['time'], $forecast['tempe'], $forecast['tempe_comf'], $forecast['precip_prob'])) {
                //залогированить
                continue;
            }

            $time = 'Время ' . $forecast['time'];
            $temp = 'Температура '. $forecast['tempe'];
            $tempSense = 'Ощущается как '. $forecast['tempe_comf'];
            $rainChance = 'Вероятность осадков '. $forecast['precip_prob'] . '%';
            print_r(implode('; ', [$time, $temp, $tempSense, $rainChance]). PHP_EOL);
        }



        return 1;
    }

    private function testSave()
    {
        $mailRuWeather = new MailRuWeather();
        $mailRuWeather->setDatetime(new \DateTime());
        $mailRuWeather->setRainChance(2);
        $mailRuWeather->setTempSense('+20');
        $mailRuWeather->setTemp('+29');
        $this->mailRuWeatherRepository->save($mailRuWeather);
    }
}