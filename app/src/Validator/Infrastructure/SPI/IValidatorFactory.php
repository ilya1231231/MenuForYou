<?php

namespace App\Validator\Infrastructure\SPI;


use App\Validator\Infrastructure\IValidator;

interface IValidatorFactory
{
    public function createValidator(array $data, array $rules, array $messages = [], array $customAttributes = []): IValidator;
}