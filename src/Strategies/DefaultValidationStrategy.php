<?php

declare(strict_types=1);

namespace PHPValidation\Strategies;

use PHPValidation\Fields\FieldValidatorInterface;

final class DefaultValidationStrategy implements ValidationStrategyInterface
{
    /**
     * @var array<string, FieldValidatorInterface|array<string, mixed>> $validators
     */
    private array $validators = [];

    /**
     * @var array<string, string|array<string, mixed>> $customErrorMessages
     */
    private array $customErrorMessages = [];

    /**
     * @var array<string, string|array<string, mixed>> $validationErrorMessages
     */
    private array $validationErrorMessages = [];

    /**
     * @param array<string, FieldValidatorInterface|array<string, mixed>> $validators
     */
    public function setValidators(array $validators): void
    {
        $this->validators = $validators;
    }

    /**
     * @param array<string, string|array<string, mixed>> $messages
     */
    public function setCustomErrorMessages(array $messages): void
    {
        $this->customErrorMessages = $messages;
    }

    /**
     * @return array<string, string|array<string, mixed>>
     */
    public function getErrorMessages(): array
    {
        return $this->validationErrorMessages;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function run(array $data): void
    {
        $this->validationErrorMessages = $this->recursiveGetErrorMessages($this->validators, $data, $this->customErrorMessages, $data);
    }

    public function isValid(): bool
    {
        return count($this->validationErrorMessages) === 0;
    }

    /**
     * @param array<string, FieldValidatorInterface|array<string, mixed>> $validators
     * @param array<string, mixed> $data
     * @param array<string, string|array<string, mixed>> $customErrorMessages
     * @param array<mixed> $givenData The data that is given to the validator.
     *
     * @return array<string, string|array<string, mixed>>
     */
    private function recursiveGetErrorMessages(
        array $validators,
        array $data,
        array $customErrorMessages,
        array $givenData
    ): array {
        $errorMessages = [];

        foreach ($validators as $fieldKey => $fieldValidators)
        {
            $fieldExists = array_key_exists($fieldKey, $data);
            $fieldValue = $fieldExists ? $data[$fieldKey] : null;

            if (!$this->isNestedFieldValidatorArray($fieldValidators))
            {
                $fieldErrorMessages = $this->getErrorMessagesFromFieldValidatorsArray(
                    $fieldValidators,
                    $fieldExists,
                    $fieldValue,
                    $givenData
                );

                if (count($fieldErrorMessages) > 0)
                {
                    $errorMessages[$fieldKey] = $this->replaceErrorMessagesWithCustomOnes(
                        $fieldKey,
                        $fieldErrorMessages,
                        $customErrorMessages
                    );
                }
            }
            else
            {
                $nestedData = is_array($fieldValue) ? $fieldValue : [];
                $nestedCustomErrorMessages = [];

                if (array_key_exists($fieldKey, $customErrorMessages) && is_array($customErrorMessages[$fieldKey]))
                {
                    $nestedCustomErrorMessages = $customErrorMessages[$fieldKey];
                }

                $nestedErrorMessages = $this->recursiveGetErrorMessages(
                    $fieldValidators,
                    $nestedData,
                    $nestedCustomErrorMessages,
                    $givenData
                );

                if (count($nestedErrorMessages) > 0)
                {
                    $errorMessages[$fieldKey] = $nestedErrorMessages;
                }
            }
        }

        return $errorMessages;
    }

    /**
     * @param array<mixed> $array
     */
    private function isNestedFieldValidatorArray(array $array): bool
    {
        $values = array_values($array);

        foreach ($values as $value)
        {
            if (is_array($value))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<FieldValidatorInterface> $fieldValidators
     * @param array<mixed> $givenData The data that is given to the validator.
     */
    private function getErrorMessagesFromFieldValidatorsArray(
        array $fieldValidators,
        bool $fieldExists,
        mixed $data,
        array $givenData
    ): array {
        $errorMessages = [];

        foreach ($fieldValidators as $fieldValidator)
        {
            // Skip this validator when the field does not exist
            if ($fieldValidator->fieldNeedsToExist() && !$fieldExists)
            {
                continue;
            }

            if (!$fieldValidator->isValid($fieldExists, $data, $givenData))
            {
                $errorMessages[$fieldValidator->getKey()] = $fieldValidator->getErrorMessage();
                break;
            }
        }

        return $errorMessages;
    }

    function replaceErrorMessagesWithCustomOnes(
        string $fieldKey,
        array $errorMessages,
        array $customErrorMessages
    ): array {
        $replacedMessages = [];

        if (!array_key_exists($fieldKey, $customErrorMessages))
        {
            return $errorMessages;
        }

        foreach ($errorMessages as $fieldValidatorKey => $defaultMessage)
        {
            if (in_array($fieldValidatorKey, array_keys($customErrorMessages[$fieldKey])))
            {
                $replacedMessages[$fieldValidatorKey] = $customErrorMessages[$fieldKey][$fieldValidatorKey];
            }
            else
            {
                $replacedMessages[$fieldValidatorKey] = $defaultMessage;
            }
        }

        return $replacedMessages;
    }
}
