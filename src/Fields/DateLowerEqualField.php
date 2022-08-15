<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

use DateTime;
use DateTimeInterface;
use PHPValidation\Helpers\DateTimeHelper;

final class DateLowerEqualField implements FieldValidatorInterface
{
    private DateTimeInterface $date;
    private string $format;

    /**
     * This array field must be lower than, or equal to the given date.
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
        return 'dateLowerEqual';
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

        return $fieldDateObject->getTimestamp() <= $this->date->getTimestamp();
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain a date that is lower than, or equal to: '.$this->date->format($this->format);
    }
}
