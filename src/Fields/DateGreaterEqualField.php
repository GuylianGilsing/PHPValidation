<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

use DateTime;
use DateTimeInterface;

final class DateGreaterEqualField implements FieldValidatorInterface
{
    private DateTimeInterface $date;
    private string $format;

    /**
     * This array field must be greater than, or equal to the given date.
     */
    public function __construct(DateTimeInterface $date, string $format = 'Y-m-d H:i:s')
    {
        $this->date = $date;
        $this->format = $format;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'dateGreaterEqual';
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

        $fieldDateObject = $fieldData;

        if (is_string($fieldData))
        {
            $strDateObject = DateTime::createFromFormat($this->format, $fieldData);

            if (!($strDateObject instanceof DateTimeInterface))
            {
                return false;
            }

            $fieldDateObject = $strDateObject;
        }

        return $fieldDateObject->getTimestamp() >= $this->date->getTimestamp();
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain a date that is greater than, or equal to: '.$this->date->format($this->format);
    }
}
