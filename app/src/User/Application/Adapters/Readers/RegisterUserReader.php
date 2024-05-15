<?php

namespace App\User\Application\Adapters\Readers;

use App\Shared\Infrastructure\SPI\User\Registration\IRegisterUserReader;
use App\User\Application\DTO\IRegisterUserDto;
use App\Validator\Infrastructure\SPI\IValidatorFactory;

class RegisterUserReader implements IRegisterUserReader
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