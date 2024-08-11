<?php

namespace App\Modules\Telegram\Application\Services;

use App\Modules\Telegram\Application\DTO\TelegramMessageDto;

class TelegramNotifierService
{
    public function __construct(
        private readonly string $telegramApiToken,
        private readonly string $telegramApiUrl
    )
    {
    }

    public function sendMessage(TelegramMessageDto $dto): void
    {
        $query = [
            'chat_id' => $dto->chat_id,
            'text' => $dto->text,
            'parse_mode' => $dto->parse_mode,
        ];
        $queryParams = http_build_query($query);

        $url = $this->telegramApiUrl . '/bot' . $this->telegramApiToken . '/sendMessage?' . $queryParams;
        file_get_contents($url);
    }
}