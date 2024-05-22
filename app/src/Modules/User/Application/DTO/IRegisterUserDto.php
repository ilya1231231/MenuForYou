<?php
namespace App\Modules\User\Application\DTO;

interface IRegisterUserDto
{
    public function setEmail(string $email): void;

    public function setPassword(string $password): void;

    public function getEmail(): string;

    public function getPassword(): string;
}