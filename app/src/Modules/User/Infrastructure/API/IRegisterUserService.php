<?php
namespace App\Modules\User\Infrastructure\API;

use App\Modules\User\Application\DTO\IRegisterUserDto;

interface IRegisterUserService
{
    public function register(IRegisterUserDto $dto): int;

}