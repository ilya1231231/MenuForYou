<?php

namespace App\Modules\User\Infrastructure\API;

use App\Modules\User\Application\DTO\ILoginUserDto;

interface ILoginUserService
{
    public function login(ILoginUserDto $dto): int;
}