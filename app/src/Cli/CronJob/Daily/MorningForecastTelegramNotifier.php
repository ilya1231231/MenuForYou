<?php

namespace App\Cli\CronJob\Daily;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\MailRuWeather;
use App\Modules\MailRuWeather\Infrastructure\Dbal\Repository\MailRuWeatherRepository;
use App\Modules\Telegram\Application\DTO\TelegramMessageDto;
use App\Modules\Telegram\Application\Services\TelegramNotifierService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'notify:morning_forecast')]
class MorningForecastTelegramNotifier extends Command
{
    public function __construct(
        private readonly MailRuWeatherRepository $mailRuWeatherRepository,
        private readonly TelegramNotifierService $telegramNotifierService,
        private readonly string $telegramChatId,
    ){
        parent::__construct();
    }

    //php bin/console notify:morning_forecast
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $datetime = new \DateTime();
        $todayForecasts = $this->mailRuWeatherRepository->getAllByDay($datetime);
        $rainForecast = $this->getRainForecast($todayForecasts);
        $dto = new TelegramMessageDto($this->telegramChatId, $rainForecast, 'html');
        $this->telegramNotifierService->sendMessage($dto);
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
            $array = array_values($chunk);
            $rainBeginForecast = array_shift($array);
            if (count($chunk) === 1) {
                $rainForecast = $rainForecast . 'В ' . $rainBeginForecast->getDatetime()->format('G:i') . '. ';
                continue;
            }

            $rainEndForecast = end($chunk);
            $timeBegin = $rainBeginForecast->getDatetime()->format('G:i');
            $timeEnd = $rainEndForecast->getDatetime()->format('G:i');
            $forecast = 'C ' . $timeBegin . ' до ' . $timeEnd . '. ';
            $rainForecast = $rainForecast . $forecast;
        }

        return $rainForecast;
    }
}