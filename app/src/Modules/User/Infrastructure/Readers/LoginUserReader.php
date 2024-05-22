<?php

namespace App\Modules\User\Infrastructure\Readers;

use App\Modules\User\Application\DTO\ILoginUserDto;

class LoginUserReader
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