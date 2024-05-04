<?php

namespace App\Shared\Infrastructure\SPI\User\Login;

use App\User\Application\DTO\ILoginUserDto;

interface ILoginUserService
{
    public function login(ILoginUserDto $dto): int;
}