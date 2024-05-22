<?php

namespace App\Modules\User\Application\DTO;

class RegisterUserDto implements IRegisterUserDto
{
    private string $email;

    private string $password;

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}