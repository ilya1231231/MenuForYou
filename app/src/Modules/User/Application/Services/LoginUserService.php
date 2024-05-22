<?php

namespace App\Modules\User\Application\Services;

use App\Modules\User\Application\DTO\ILoginUserDto;
use App\Modules\User\Infrastructure\API\ILoginUserService;

class LoginUserService implements ILoginUserService
{

    public function login(ILoginUserDto $dto): int
    {
        return 1;
    }
}