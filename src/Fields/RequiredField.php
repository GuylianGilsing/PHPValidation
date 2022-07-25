<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class RequiredField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return false;
    }

    public function getKey(): string
    {
        return 'required';
    }

    public function isValid(bool $fieldExists, mixed $data): bool
    {
        return $fieldExists;
    }

    public function getErrorMessage(): string
    {
        return 'This field is required';
    }
}
