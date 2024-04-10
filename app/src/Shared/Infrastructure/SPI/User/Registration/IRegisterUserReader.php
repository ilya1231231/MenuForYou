<?php

namespace App\Shared\Infrastructure\SPI\User\Registration;

use App\User\Application\DTO\IRegisterUserDto;

interface IRegisterUserReader
{
    public function readJson(string $raw): IRegisterUserDto;
}