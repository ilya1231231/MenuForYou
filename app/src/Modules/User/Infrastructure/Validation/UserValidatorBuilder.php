<?php

namespace App\Modules\User\Application\Validation;

use App\Validator\Infrastructure\IValidator;
use App\Validator\Infrastructure\ValidatorFactory;

class UserValidatorBuilder
{
    private ValidatorFactory $validatorFactory;

    public function __construct(
        ValidatorFactory $validatorFactory
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