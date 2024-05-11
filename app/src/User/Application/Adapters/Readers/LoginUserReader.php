<?php

namespace App\User\Application\Adapters\Readers;
use App\Shared\Infrastructure\SPI\User\Login\ILoginUserReader;
use App\User\Application\DTO\ILoginUserDto;

class LoginUserReader implements ILoginUserReader
{
    private ILoginUserDto $loginUserDto;

    public function __construct(ILoginUserDto $loginUserDto)
    {
        $this->loginUserDto = $loginUserDto;
    }

    public function readJson(string $raw): ILoginUserDto
    {
        $rawData = json_decode($raw, true);
//        $this->registerUserDto->setEmail('wwww');
//        $this->registerUserDto->setPassword('wwww222');

        return $this->loginUserDto;
    }
}