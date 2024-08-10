<?php

namespace App\Cli\CronJob\Daily;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\MailRuWeather;
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

        $rainForecast = $this->getRainForecast($todayForecasts);

        $textMessage = $rainForecast;
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

    /**
     * @param $forecasts MailRuWeather[]
     * */
    private function getRainForecast(array $forecasts): string
    {
        if (!$forecasts) {
            return 'Дождя не ожидается';
        }

        $highRainChanceForecasts = array_filter($forecasts, static fn(MailRuWeather $el) => $el->getRainChance() > 50);

        $everyHourRainChunks = [];
        foreach ($highRainChanceForecasts as $forecast) {
            if (!$everyHourRainChunks) {
                $everyHourRainChunks[][] = $forecast;
                continue;
            }

            $chunkKey = array_key_last($everyHourRainChunks);
            $lastForecastOfChunk = end($everyHourRainChunks[$chunkKey]);
            $datetimeDiff = $forecast->getDatetime()->diff($lastForecastOfChunk->getDatetime());
            if ($datetimeDiff->h > 1) {
                $everyHourRainChunks[][] = $forecast;
                continue;
            }

            $everyHourRainChunks[$chunkKey][] = $forecast;
        }

        $rainForecast = 'Возможен дождь! ';
        foreach ($everyHourRainChunks as $chunk) {
            $rainBeginForecast = array_shift($chunk);
            $rainEndForecast = end($chunk);
            $timeBegin = $rainBeginForecast->getDatetime()->format('G:i');
            $timeEnd = $rainEndForecast->getDatetime()->format('G:i');
            $forecast = 'C ' . $timeBegin . ' до ' . $timeEnd . '. ';
            $rainForecast = $rainForecast . $forecast;
        }

        return $rainForecast;
    }
}