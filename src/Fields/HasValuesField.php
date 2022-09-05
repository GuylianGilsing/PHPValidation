<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class HasValuesField implements FieldValidatorInterface
{
    /**
     * @var array<mixed> $values
     */
    private array $values = [];

    /**
     * This array field must contain all given values.
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
        return 'hasValues';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_array($fieldData))
        {
            return false;
        }

        $fieldValues = array_values($fieldData);

        foreach ($this->values as $requiredValue)
        {
            if (!in_array($requiredValue, $fieldValues))
            {
                return false;
            }
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain all following values: '.implode(', ', $this->values);
    }
}
