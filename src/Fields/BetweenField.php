<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class BetweenField implements FieldValidatorInterface
{
    private int|float $min;
    private int|float $max;

    /**
     * This array field must be between two given values.
     */
    public function __construct(int|float $min, int|float $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'between';
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

        return $number >= $this->min && $number <= $this->max;
    }

    public function getErrorMessage(): string
    {
        return 'This field must be between: '.$this->min.' and '.$this->max;
    }
}
