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

    /**
     * @param mixed $fieldData The data that the current field has. Defaults to null when the field does not exist.
     * @param array<mixed> $givenData The data that is given to the validator.
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool;

    public function getErrorMessage(): string;
}
