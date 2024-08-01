<?php
namespace App\Cli\InfoParser;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(name: 'parse:start_parse_info')]
class InfoParserIndex extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        echo '2222222';
        return 1;
    }
}