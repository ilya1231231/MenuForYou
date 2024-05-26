<?php

namespace App\Core\Exceptions;

interface IPublicException
{
    public function __toString(): string;

    public function getUnnamedError(): string;

    /**
     * @return array
     * [
     *   'field_name_1' =>  'all fields errors as str. Separator is ";" '
     *   'field_name_2' =>  'all fields errors as str. Separator is ";" '
     * ]
     */
    public function getNamedErrors(): array;
}