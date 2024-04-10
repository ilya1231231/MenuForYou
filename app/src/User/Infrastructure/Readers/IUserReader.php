<?php
namespace App\User\Infrastructure\Readers;

use App\User\Application\DTO\IRegisterUserDto;
use Symfony\Component\HttpFoundation\Request;

interface IUserReader
{
    public function readRegisterRequest(Request $request): IRegisterUserDto;
}