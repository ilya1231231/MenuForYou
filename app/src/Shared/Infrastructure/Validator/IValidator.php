<?php

namespace App\Infastructure\Validator;


use Illuminate\Support\MessageBag;

/**
 * Это методы ларавел валидатора - смотри документацию по ним
 */
interface IValidator
{
    /**
     * Запустить валидатор
     *
     * @throws \Exception
     * @return array Провалидированные поля
     */
    public function validateOrEx(): array;

    /**
     * Запустит валидатор, если не запускался, потом вернет поля прошедшие валидаци.
     */
    public function validated(): array;

    /**
     * Всегда запускает валидатор и возврощает bool результат.
     * Ошибки можно собрать self::errors()
     */
    public function fails(): bool;

    /**
     * Не запускает валидатор - собрать ошибки запущенного ранее валидатора
     */
    public function failed(): array;

    /**
     *
     * @param string|array $attribute
     * @param string|array $rules
     * @param callable $callback
     * @return $this
     */
    public function sometimes($attribute, $rules, callable $callback): IValidator;

    /**
     * @param callable|string $callback
     * @return $this
     */
    public function after($callback): IValidator;

    /**
     * Звпускает валидатор, если он небыл запущен и потом отдает ошибки
     *
     * @return MessageBag
     */
    public function errors(): MessageBag;

    /**
     * Загрузить в валидатор новые данные, после этого его можно заново запускать
     */
    public function setNewData(array $data): IValidator;
}