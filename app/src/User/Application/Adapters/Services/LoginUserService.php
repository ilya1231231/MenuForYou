<?php

namespace App\User\Application\Adapters\Services;

use App\Shared\Infrastructure\SPI\User\Login\ILoginUserService;
use App\User\Application\DTO\ILoginUserDto;

class LoginUserService implements ILoginUserService
{

    public function login(ILoginUserDto $dto): int
    {
        return 1;
    }
}