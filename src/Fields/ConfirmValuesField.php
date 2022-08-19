<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

use PHPValidation\Helpers\ArrayHelper;

final class ConfirmValuesField implements FieldValidatorInterface
{
    /**
     * @var array<string> $confirmationFieldKeyTree
     */
    private array $confirmationFieldKeyTree = [];

    /**
     * This array field must have the same value as another field.
     *
     * @param string $confirmationFieldKey This key refers to a field within the global validator structure.
     * Use dot notation to reference nested fields:
     * `key1.nestedKey1.nestedKey2` translates to `['key1' => ['nestedKey1' => [nestedKey2 => '']]]`
     */
    public function __construct(string $confirmationFieldKey)
    {
        $this->confirmationFieldKeyTree = ArrayHelper::convertDotNotationToKeysArray($confirmationFieldKey);
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'confirmValues';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        $retrievedValue = ArrayHelper::getArrayValue($this->confirmationFieldKeyTree, $givenData);

        return $fieldData === $retrievedValue;
    }

    public function getErrorMessage(): string
    {
        $keys = implode(',', $this->confirmationFieldKeyTree);

        return 'This field must contain the following string: "'.$keys.'"';
    }
}
