<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class IsNumericField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isNumeric';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        return is_numeric($fieldData);
    }

    public function getErrorMessage(): string
    {
        return 'This field must be numeric';
    }
}
