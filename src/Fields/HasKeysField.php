<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class HasKeysField implements FieldValidatorInterface
{
    /**
     * @var array<mixed> $keys
     */
    private array $keys = [];

    /**
     * This array field must contain all given keys.
     *
     * @param array<mixed> $keys An indexed array of key names.
     */
    public function __construct(array $keys)
    {
        $this->keys = $keys;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'hasKeys';
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

        $fieldKeys = array_keys($fieldData);

        foreach ($this->keys as $requiredKey)
        {
            if (!in_array($requiredKey, $fieldKeys))
            {
                return false;
            }
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain all following keys: '.implode(', ', $this->keys);
    }
}
