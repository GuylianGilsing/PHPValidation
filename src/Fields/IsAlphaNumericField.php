<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

use PHPValidation\Helpers\Regex;

final class IsAlphaNumericField implements FieldValidatorInterface
{
    /**
     * @var array<string> $extraCharacters
     */
    private array $extraCharacters = [];

    /**
     * @param array<string> $extraCharacters An indexed array of strings that contain characters that can exist
     * within the string.
     */
    public function __construct(array $extraCharacters = [])
    {
        $this->extraCharacters = $extraCharacters;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'isAlphaNumeric';
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

        // Constructs the final regex that dictates which values will be valid during the final check
        $regexParts = ['[\n\r\s\t]', '[A-z]', '[0-9]'];
        $extraCharactersRegexPart = $this->createRegexRangeFromCharacters($this->extraCharacters);

        if (is_string($extraCharactersRegexPart))
        {
            $regexParts[] = $extraCharactersRegexPart;
        }

        $regex = $this->constructRegex($regexParts);
        $cleanedString = preg_replace('~'.$regex.'~', '', $fieldData);

        return strlen($cleanedString) === 0;
    }

    public function getErrorMessage(): string
    {
        return 'This field can only contain normal, non-special, characters, numbers, and whitespace';
    }

    /**
     * @param array<string> $characters An indexed array of strings that contain characters that can exist
     * within the string.
     */
    private function createRegexRangeFromCharacters(array $characters): ?string
    {
        if (count($characters) === 0)
        {
            return null;
        }

        $rangeBody = '';

        foreach ($characters as $character)
        {
            $rangeBody .= Regex::escapeSpecialCharacters($character);
        }

        return '['.$rangeBody.']';
    }

    /**
     * @param array<string> $parts
     */
    private function constructRegex(array $parts): string
    {
        return '('.implode('|', $parts).')+';
    }
}
