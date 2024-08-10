<?php

namespace App\Cli\CronJob\Daily;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Repository\MailRuWeatherRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'notify:morning_forecast')]
class MorningForecastTelegramNotifier extends Command
{
    public function __construct(
        private readonly MailRuWeatherRepository $mailRuWeatherRepository,
        private readonly string $telegramApiToken,
        private readonly string $telegramChatId,
        private readonly string $telegramApiUrl
    ){
        parent::__construct();
    }

    //php bin/console notify:morning_forecast
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $datetime = new \DateTime();
        $todayForecasts = $this->mailRuWeatherRepository->getAllByDay($datetime);

        $highRainChance = [];
        $tempByHour = [];
        foreach ($todayForecasts as $forecast) {
            $tempByHour[] = $forecast->getTemp();
            if ($forecast->getRainChance() > 60) {
                $highRainChance[] = $forecast;
            }
        }

        $textMessage = 'text';
        $query = [
            'chat_id' 	=> $this->telegramChatId,
            'text'  	=> $textMessage,
            'parse_mode' => 'html',
        ];
        $queryParams = http_build_query($query);

        $url = $this->telegramApiUrl . '/bot'. $this->telegramApiToken .'/sendMessage?' . $queryParams;
        file_get_contents($url);

        return 1;
    }
}