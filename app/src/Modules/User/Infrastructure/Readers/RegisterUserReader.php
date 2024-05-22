<?php

namespace App\Modules\User\Infrastructure\Readers;

use App\Validator\Infrastructure\SPI\IValidatorFactory;
use App\Modules\User\Application\DTO\IRegisterUserDto;

class RegisterUserReader
{
    private IRegisterUserDto $registerUserDto;
    private IValidatorFactory $validatorFactory;

    public function __construct(
        IRegisterUserDto $registerUserDto,
        IValidatorFactory $validatorFactory,
    ){
        $this->registerUserDto = $registerUserDto;
        $this->validatorFactory = $validatorFactory;
    }

    public function readJson(string $raw): IRegisterUserDto
    {
        $rawData = json_decode($raw, true);
        $validator = $this->validatorFactory->createValidator($rawData);
        $validator->validateOrEx();
        $this->registerUserDto->setEmail($rawData['email']);
        $this->registerUserDto->setPassword($rawData['password']);
        return $this->registerUserDto;
    }
}