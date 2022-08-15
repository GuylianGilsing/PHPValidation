<?php

declare(strict_types=1);

namespace PHPValidation\Helpers;

use DateTime;
use DateTimeInterface;

final class DateTimeHelper
{
    public static function parseDateTimeObjectFromMixed(mixed $date, string $format): ?DateTimeInterface
    {
        if ($date instanceof DateTimeInterface)
        {
            return $date;
        }

        if (is_string($date))
        {
            $strDateObject = DateTime::createFromFormat($format, $date);

            if ($strDateObject instanceof DateTimeInterface)
            {
                return $strDateObject;
            }
        }

        return null;
    }
}
