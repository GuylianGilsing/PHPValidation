<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class IsArrayField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isArray';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        return is_array($fieldData);
    }

    public function getErrorMessage(): string
    {
        return 'This field must be an array';
    }
}
