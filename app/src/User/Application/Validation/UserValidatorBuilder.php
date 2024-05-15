<?php

use App\Validator\Infrastructure\IValidator;
use App\Validator\Infrastructure\SPI\IValidatorFactory;

class UserValidatorBuilder
{
    private IValidatorFactory $validatorFactory;

    public function __construct(
        IValidatorFactory $validatorFactory
    ){
        $this->validatorFactory = $validatorFactory;
    }

    public function getRegisterUserValidator(array $data): IValidator
    {
        $rules = [
            'email' => ['alpha_dash:ascii', 'min:0', 'max:50'],
            'password' => 'required|int_safe|gte:0',
        ];

        $locLabels = [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
        ];

        return $this->validatorFactory->createValidator($data, $rules, [], $locLabels);
    }
}