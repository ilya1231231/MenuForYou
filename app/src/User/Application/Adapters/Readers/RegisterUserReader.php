<?php

namespace App\User\Application\Adapters\Readers;

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
        //@todo здесь будет валидация
        $this->registerUserDto->setEmail($rawData['email']);
        $this->registerUserDto->setPassword($rawData['password']);

        return $this->registerUserDto;
    }
}