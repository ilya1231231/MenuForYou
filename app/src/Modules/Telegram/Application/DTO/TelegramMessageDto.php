<?php

namespace App\Modules\Telegram\Application\DTO;

class TelegramMessageDto
{
    public readonly int $chat_id;

    public readonly string $text;

    public readonly string $parse_mode;

    public function __construct(int $chatId, string $text, string $parseMode)
    {
        $this->chat_id = $chatId;
        $this->text = $text;
        $this->parse_mode = $parseMode;
    }

}