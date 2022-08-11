<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class ContainsField implements FieldValidatorInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'contains';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        return str_contains($fieldData, $this->value);
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain the following string: "'.$this->value.'"';
    }
}
