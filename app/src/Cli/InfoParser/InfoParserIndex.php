<?php

namespace App\Cli\InfoParser;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(name: 'parse:start_parse_info')]
class InfoParserIndex extends Command
{
    //php bin/console parse:start_parse_info
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        //find forecasts
        $c = 1;
//        $rawHtml = htmlspecialchars_decode(
//            file_get_contents('https://pogoda.mail.ru/prognoz/yoshkar-ola/24hours/')
//        );

        return 1;
    }
}