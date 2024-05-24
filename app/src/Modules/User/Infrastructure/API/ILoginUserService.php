<?php

namespace App\Modules\User\Infrastructure\API;

use App\Modules\User\Application\DTO\LoginUserDto;

interface ILoginUserService
{
    public function login(LoginUserDto $dto): int;
}