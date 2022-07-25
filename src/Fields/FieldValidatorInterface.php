<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

interface FieldValidatorInterface
{
    /**
     * Internal function that skips this validator when the field does not exist within a given data array.
     */
    public function fieldNeedsToExist(): bool;

    public function getKey(): string;
    public function isValid(bool $fieldExists, mixed $data): bool;
    public function getErrorMessage(): string;
}
