<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class EqualsField implements FieldValidatorInterface
{
    private mixed $value;
    private bool $strict = false;

    public function __construct(mixed $value, bool $strict = false)
    {
        $this->value = $value;
        $this->strict = $strict;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'equals';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if ($this->strict)
        {
            return $fieldData === $this->value;
        }

        return $fieldData == $this->value;
    }

    public function getErrorMessage(): string
    {
        return 'This field must match the following value: "'.$this->value.'"';
    }
}
