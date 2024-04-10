<?php
namespace App\Shared\Infrastructure\SPI\User\Registration;
use App\User\Application\DTO\IRegisterUserDto;

interface IRegisterUserService
{
    public function register(IRegisterUserDto $dto): int;

}