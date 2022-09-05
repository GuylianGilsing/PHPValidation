<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class InField implements FieldValidatorInterface
{
    /**
     * @var array<mixed> $values
     */
    private array $values = [];

    /**
     * This array field must contain one of the values within a given array.
     *
     * @param array<mixed> $values An indexed array.
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'in';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData) && !is_int($fieldData) && !is_float($fieldData) && !is_bool($fieldData))
        {
            return false;
        }

        return in_array($fieldData, $this->values);
    }

    public function getErrorMessage(): string
    {
        return 'This field can only contain one of following values: '.implode(', ', $this->values);
    }
}
