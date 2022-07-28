<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class MaxCountField implements FieldValidatorInterface
{
    private int $count = 0;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'maxCount';
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

        return count($fieldData) <= $this->count;
    }

    public function getErrorMessage(): string
    {
        return 'This field cannot contain more than '.$this->count.' values';
    }
}
