<?php

namespace App\Modules\User\Application\Services;

use App\Modules\User\Infrastructure\API\ILoginUserService;
use App\Modules\User\Application\DTO\LoginUserDto;

class LoginUserService implements ILoginUserService
{

    public function login(LoginUserDto $dto): int
    {
        //@todo Здесь происходит процесс авторизации
        return 1;
    }
}