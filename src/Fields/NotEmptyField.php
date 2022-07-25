<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class NotEmptyField implements FieldValidatorInterface
{
    private string $targetWhitespaceRegex = '[\\n\\r\s\\t]+';

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'notEmpty';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (is_string($fieldData))
        {
            $removedWhitespaceString = preg_replace('~'.$this->targetWhitespaceRegex.'~', '', $fieldData);

            return strlen($removedWhitespaceString) > 0;
        }

        if (is_array($fieldData))
        {
            $keys = array_keys($fieldData);
            $values = array_values($fieldData);

            return count($keys) > 0 || count($values) > 0;
        }

        return false;
    }

    public function getErrorMessage(): string
    {
        return 'This field cannot be empty';
    }
}
