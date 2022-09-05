<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class GreaterEqualField implements FieldValidatorInterface
{
    private int|float $value;

    /**
     * This array field must be greater than, or equal to, the given value.
     */
    public function __construct(int|float $value)
    {
        $this->value = $value;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'greaterEqual';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData) && !is_numeric($fieldData) && !is_int($fieldData) && !is_float($fieldData))
        {
            return false;
        }

        $number = $fieldData;

        if (is_string($number) && !is_numeric($number))
        {
            return false;
        }

        $number = floatval($number);

        return $number >= $this->value;
    }

    public function getErrorMessage(): string
    {
        return 'This field must be greater than, or equal to: '.$this->value;
    }
}
