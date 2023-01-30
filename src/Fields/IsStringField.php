<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class IsStringField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isString';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        return is_string($fieldData);
    }

    public function getErrorMessage(): string
    {
        return 'This field must be a string';
    }
}
