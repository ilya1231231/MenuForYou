<?php

namespace App\Modules\MailRuWeather\Infrastructure\Readers;

use Symfony\Component\DomCrawler\Crawler;

class MailRuWeatherReader
{
    public function __construct(
        private readonly string $mailRuWeatherUrl,
    )
    {
    }

    public function getForecastsAsJson(): string
    {
        $parseUrl = $this->mailRuWeatherUrl . '/prognoz/yoshkar-ola/24hours/';
        $rawHtml = file_get_contents($parseUrl);
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

        return $json;
    }
}