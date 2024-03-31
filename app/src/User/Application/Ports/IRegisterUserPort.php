<?php
namespace App\User\Application\Ports;
use App\User\Infrastructure\Dbal\Entity\User;

interface IRegisterUserPort
{
    public function register(User $user): int;

}