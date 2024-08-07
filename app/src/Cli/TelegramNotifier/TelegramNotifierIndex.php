<?php

namespace App\Cli\TelegramNotifier;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Repository\MailRuWeatherRepository;
use App\Modules\MailRuWeather\Infrastructure\Readers\MailRuWeatherReader;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TelegramNotifierIndex
{
    public function __construct(){

    }

    //php bin/console parse:start_parse_info
    public function execute(InputInterface $input, OutputInterface $output): int
    {

//        $token = "6975459816:AAFUIqlAjL9Kz0YsKLdoZQbBLuf4pRu-eig";
//        $chat_id = -4207384718;
//        $textMessage = implode('; ', [$time, $temp, $tempSense, $rainChance]);
//        $textMessage = urlencode($textMessage);
//
//        $urlQuery = "https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $chat_id ."&text=" . $textMessage;
//        $result = file_get_contents($urlQuery);

        return 1;
    }
}