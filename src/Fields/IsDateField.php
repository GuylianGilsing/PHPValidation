<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

use DateTimeInterface;

final class IsDateField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isDate';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData) && !($fieldData instanceof DateTimeInterface))
        {
            return false;
        }

        if (($fieldData instanceof DateTimeInterface))
        {
            return true;
        }

        return is_int(strtotime($fieldData));
    }

    public function getErrorMessage(): string
    {
        return '
            This field must contain a valid date string or an object that implements the "'
            .DateTimeInterface::class.
            '" interface';
    }
}
