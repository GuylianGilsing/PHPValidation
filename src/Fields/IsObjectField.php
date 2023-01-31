<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class IsObjectField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isObject';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        return is_object($fieldData);
    }

    public function getErrorMessage(): string
    {
        return 'This field must be an object';
    }
}
