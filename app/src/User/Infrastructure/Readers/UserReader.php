<?php
namespace App\User\Infrastructure\Readers;

use App\User\Application\DTO\IRegisterUserDto;
use Symfony\Component\HttpFoundation\Request;

class UserReader implements IUserReader
{
    private IRegisterUserDto $registerUserDto;

    public function __construct(IRegisterUserDto $registerUserDto)
    {
        $this->registerUserDto = $registerUserDto;
    }

    public function readRegisterRequest(Request $request): IRegisterUserDto
    {
        $this->registerUserDto->setEmail(random_int(1, 999999) . "@mail.ru");
        $this->registerUserDto->setPassword(random_int(1, 999999) . "@mail.ru");
    }
}