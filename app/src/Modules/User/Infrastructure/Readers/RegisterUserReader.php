<?php

namespace App\Modules\User\Infrastructure\Readers;

use App\Modules\User\Application\DTO\RegisterUserDto;
use App\Validator\Infrastructure\SPI\IValidatorFactory;

class RegisterUserReader
{
    private IValidatorFactory $validatorFactory;

    public function __construct(
        IValidatorFactory $validatorFactory,
    ){
        $this->validatorFactory = $validatorFactory;
    }

    public function readJson(string $raw): RegisterUserDto
    {
        $rawData = json_decode($raw, true);
        $rules = [
            'email' => 'required|email',
            'password' => 'required|password',
        ];
        $labels = [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
        ];
        $validator = $this->validatorFactory->createValidator($rawData, $rules, [], $labels);
        $validator->validateOrEx();

        $dto = new RegisterUserDto();
        $dto->setEmail($rawData['email']);
        $dto->setPassword($rawData['password']);

        return $dto;
    }
}