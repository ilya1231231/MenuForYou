<?php

namespace App\Cli\CronJob\Daily;

use App\Modules\MailRuWeather\Application\DTO\ForecastByHourDto;
use App\Modules\MailRuWeather\Application\Services\ForecastAnalyzerService;
use App\Modules\MailRuWeather\Application\Services\ParseForecastsService;
use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\MailRuWeather;
use App\Modules\MailRuWeather\Infrastructure\Dbal\Repository\MailRuWeatherRepository;
use App\Modules\MailRuWeather\Infrastructure\Readers\MailRuWeatherReader;
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
        private readonly ParseForecastsService $parseForecastsService,
        private readonly ForecastAnalyzerService $forecastAnalyzerService,
        private readonly TelegramNotifierService $telegramNotifierService,
        private readonly MailRuWeatherReader $mailRuWeatherReader,
        private readonly string $telegramChatId,
    ){
        parent::__construct();
    }

    //php bin/console notify:morning_forecast
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $json = $this->mailRuWeatherReader->getForecastsAsJson();
        $todayForecasts = $this->parseForecastsService->parseForecastsJson($json)->currentDayForecasts;
        if (!$todayForecasts) {
            throw new \Exception('Не удалось спарсить прогнозы за сегодня');
        }
        $rainForecast = $this->forecastAnalyzerService->getRainForecastByDay($todayForecasts);
        $dto = new TelegramMessageDto($this->telegramChatId, $rainForecast, 'html');
        $this->telegramNotifierService->sendMessage($dto);
        return 1;
    }
}