<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

use DateTime;
use DateTimeInterface;

final class DateHasFormatField implements FieldValidatorInterface
{
    private string $format;

    public function __construct(string $format)
    {
        $this->format = $format;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'dateHasFormat';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData) && !($fieldData instanceof DateTimeInterface))
        {
            return false;
        }

        $dateString = $fieldData;

        if (($fieldData instanceof DateTimeInterface))
        {
            $formattedDate = $fieldData->format($this->format);
            $dateString = is_string($formattedDate) ? $formattedDate : '';
        }

        $date = DateTime::createFromFormat($this->format, $dateString);

        return $date instanceof DateTimeInterface;
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain a date with the following format: '.$this->format;
    }
}
