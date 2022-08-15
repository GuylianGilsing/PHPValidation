<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

use DateTime;
use DateTimeInterface;
use PHPValidation\Helpers\DateTimeHelper;

final class DateBetweenField implements FieldValidatorInterface
{
    private DateTimeInterface $min;
    private DateTimeInterface $max;
    private string $format;

    /**
     * This array field must be between two given dates.
     */
    public function __construct(DateTimeInterface $min, DateTimeInterface $max, string $format = 'Y-m-d H:i:s')
    {
        $this->min = $min;
        $this->max = $max;
        $this->format = $format;
    }

    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'dateBetween';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        $fieldDateObject = DateTimeHelper::parseDateTimeObjectFromMixed($fieldData, $this->format);

        if ($fieldDateObject === null)
        {
            return false;
        }

        $fieldDateTimestamp = $fieldDateObject->getTimestamp();

        return $fieldDateTimestamp >= $this->min->getTimestamp() &&
               $fieldDateTimestamp <= $this->max->getTimestamp();
    }

    public function getErrorMessage(): string
    {
        $dateRange = $this->min->format($this->format).' and '.$this->max->format($this->format);

        return 'This field must contain a date that is between: '.$dateRange;
    }
}
