<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class IsAlphabeticField implements FieldValidatorInterface
{
    private string $targetCharactersAndWhitespaceRegex = '([\n\r\s\t]|[A-z])+';

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isAlphabetic';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData))
        {
            return false;
        }

        $cleanedString = preg_replace('~'.$this->targetCharactersAndWhitespaceRegex.'~', '', $fieldData);

        return strlen($cleanedString) === 0;
    }

    public function getErrorMessage(): string
    {
        return 'This field can only contain normal, non-special, characters and whitespace';
    }
}
