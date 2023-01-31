<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class ObjectOfTypeField implements FieldValidatorInterface
{
    private string $type;

    /**
     * This field must contain an object that has the desired type.
     *
     * @param string $type The `Class::name` string of the desired type.
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'objectOfType';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_object($fieldData))
        {
            return false;
        }

        return is_a($fieldData, $this->type);
    }

    public function getErrorMessage(): string
    {
        return 'This field can only contain an object of the type: "'.$this->type.'"';
    }
}
