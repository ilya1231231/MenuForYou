<?php

namespace App\User\Application\Adapters;

use App\Shared\Infrastructure\SPI\User\Registration\IRegisterUserReader;
use App\User\Application\DTO\IRegisterUserDto;

class RegisterUserReader implements IRegisterUserReader
{
    private IRegisterUserDto $registerUserDto;

    public function __construct(IRegisterUserDto $registerUserDto)
    {
        $this->registerUserDto = $registerUserDto;
    }

    public function readJson(string $raw): IRegisterUserDto
    {
        $rawData = json_decode($raw, true);
        $this->registerUserDto->setEmail('zzzzzz@mail.ru');
        $this->registerUserDto->setPassword('wwww222');

        return $this->registerUserDto;
    }
}