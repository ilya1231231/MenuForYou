<?php

namespace App\Core\Exceptions;

class ValidationException extends \Exception
{
    private $unnamedError;
    private $namedErrors = [];

    public function __construct(string $unnamedError, array $namedErrors = [], Throwable $previous = null)
    {
        $this->unnamedError = $unnamedError;
        $this->setNamedErrors($namedErrors);

        $strErr = (string)$this;
        parent::__construct($strErr, $previous);
    }

    public function getUnnamedError(): string
    {
        return $this->unnamedError;
    }

    public function getNamedErrors(): array
    {
        return $this->namedErrors;
    }

    public function __toString(): string
    {
        return $this->unnamedError
            . (($this->unnamedError && $this->namedErrors ? ('; ') : '') . implode('; ', $this->namedErrors));
    }

    public function toString(string $errSep = '; '): string
    {
        return $this->unnamedError
            . (($this->unnamedError && $this->namedErrors ? $errSep : '') . implode($errSep, $this->namedErrors));
    }

    private function setNamedErrors(array $errors): void
    {
        $preparedErrors = [];

        foreach ($errors as $fieldName => $fieldErrors) {
            if (is_array($fieldErrors)) {
                $preparedErrors[$fieldName] = implode('; ', $fieldErrors);
            } else {
                $preparedErrors[$fieldName] = (string)$fieldErrors;
            }
        }
        $this->namedErrors = $preparedErrors;
    }
}