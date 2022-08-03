<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class IsFloatField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isFloat';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData) && !is_float($fieldData) && !is_int($fieldData))
        {
            return false;
        }

        // Matches a sequence of digits with only 1 optional period
        preg_match('~^\d+(?:\.\d+)?$~', strval($fieldData), $matches);

        $floatVal = null;

        if (count($matches) === 1)
        {
            $floatVal = floatval($matches[0]);
        }

        return is_float($floatVal);
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain a floating point value';
    }
}
