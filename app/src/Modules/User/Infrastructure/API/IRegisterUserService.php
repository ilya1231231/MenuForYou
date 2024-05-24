<?php
namespace App\Modules\User\Infrastructure\API;

use App\Modules\User\Application\DTO\RegisterUserDto;

interface IRegisterUserService
{
    public function register(RegisterUserDto $dto): int;

}