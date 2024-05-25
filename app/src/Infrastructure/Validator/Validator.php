<?php

namespace App\Validator\Infrastructure;

use App\Core\Exceptions\CustomValidationException;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\MessageBag;

class Validator extends \Illuminate\Validation\Validator implements IValidator
{
    public function __construct(
        Translator $translator,
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ){
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    public function validateOrEx(): array
    {
        if (!parent::fails()) {
            return parent::validated();
        }
        throw new CustomValidationException('Переданы невалидные данные', parent::errors()->toArray());
    }

    public function validated(): array
    {
        return parent::validated();
    }

    public function fails(): bool
    {
        return parent::fails();
    }

    public function failed(): array
    {
        return parent::failed();
    }

    public function sometimes($attribute, $rules, callable $callback): IValidator
    {
        parent::sometimes($attribute, $rules, $callback);
        return $this;
    }

    /**
     * @param callable|string $callback
     * @return $this
     */
    public function after($callback): IValidator
    {
        parent::after($callback);
        return $this;
    }

    public function errors(): MessageBag
    {
        return parent::errors();
    }

    public function setNewData(array $data): IValidator
    {
        $this->messages = null;
        parent::setData($data);
        return $this;
    }
}