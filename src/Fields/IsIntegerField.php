<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class IsIntegerField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isInteger';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData) && !is_int($fieldData))
        {
            return false;
        }

        // Matches a sequence of digits with only 1 optional period
        preg_match('~^\d+$~', strval($fieldData), $matches);

        $intVal = null;

        if (count($matches) === 1)
        {
            $intVal = intval($matches[0]);
        }

        return is_int($intVal);
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain an integer value';
    }
}
