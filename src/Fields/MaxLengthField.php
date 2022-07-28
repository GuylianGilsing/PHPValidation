<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class MaxLengthField implements FieldValidatorInterface
{
    private int $length = 0;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'maxLength';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData))
        {
            return false;
        }

        return strlen($fieldData) <= $this->length;
    }

    public function getErrorMessage(): string
    {
        return 'This field cannot contain more than '.$this->length.' characters';
    }
}
