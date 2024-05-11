<?php

namespace App\Infastructure\Validator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class ValidatorFactory
{
    private $translator;
    private $factory;

    public function __construct(string $pathToValidationLangDir, string $locale)
    {
        $fileLoader = new FileLoader(new Filesystem(), $pathToValidationLangDir);
        $fileLoader->addNamespace('lang', $pathToValidationLangDir);
        $fileLoader->load('en', 'validation', 'lang');
        $this->translator = new Translator($fileLoader, $locale);

        $this->factory = new Factory($this->translator);
        $this->factory->resolver(function($translator, $data, $rules, $messages, $customAttributes){
            return new Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    public function createValidator(
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ): IValidator {
        /*** @var $validator IValidator */
        $validator = $this->factory->make($data, $rules, $messages, $customAttributes);
        return $validator;
    }

}