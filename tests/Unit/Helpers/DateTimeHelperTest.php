<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Unit\Helpers;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use PHPValidation\Helpers\DateTimeHelper;
use stdClass;

final class DateTimeHelperTest extends TestCase
{
    public function testIfCanParseStringWithMatchingFormat(): void
    {
        // Arrange
        $dateString = '2000-12-31';
        $dateFormat = 'Y-m-d';

        // Act
        $dateTimeObject = DateTimeHelper::parseDateTimeObjectFromMixed($dateString, $dateFormat);

        // Assert
        $this->assertNotNull($dateTimeObject);
        $this->assertInstanceOf(DateTimeInterface::class, $dateTimeObject);
    }

    public function testIfCannotParseStringWithNonMatchingFormat(): void
    {
        // Arrange
        $dateString = '2000-12-31';
        $dateFormat = 'Y-m-d H:i:s';

        // Act
        $dateTimeObject = DateTimeHelper::parseDateTimeObjectFromMixed($dateString, $dateFormat);

        // Assert
        $this->assertNull($dateTimeObject);
    }

    public function testIfDateTimeInterfaceObjectsAreBeingReturned(): void
    {
        // Arrange
        $dateTimeObjects = [
            DateTime::createFromFormat('Y-m-d', '2000-12-31'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2000-12-31'),
        ];

        foreach ($dateTimeObjects as $dateTimeObject)
        {
            // Act
            $parsedObject = DateTimeHelper::parseDateTimeObjectFromMixed($dateTimeObject, 'Y-m-d');

            // Assert
            $this->assertEquals($dateTimeObject, $parsedObject);
        }
    }

    public function testIfArrayValueReturnsNull(): void
    {
        // Act
        $parsedValue = DateTimeHelper::parseDateTimeObjectFromMixed([], 'Y-m-d');

        // Assert
        $this->assertNull($parsedValue);
    }

    public function testIfNonDateTimeInterfaceObjectValueReturnsNull(): void
    {
        // Act
        $parsedValue = DateTimeHelper::parseDateTimeObjectFromMixed(new stdClass, 'Y-m-d');

        // Assert
        $this->assertNull($parsedValue);
    }

    public function testIfIntegerValueReturnsNull(): void
    {
        // Act
        $parsedValue = DateTimeHelper::parseDateTimeObjectFromMixed(123456789, 'Y-m-d');

        // Assert
        $this->assertNull($parsedValue);
    }

    public function testIfFloatValueReturnsNull(): void
    {
        // Act
        $parsedValue = DateTimeHelper::parseDateTimeObjectFromMixed(1234.5678, 'Y-m-d');

        // Assert
        $this->assertNull($parsedValue);
    }

    public function testIfNullValueReturnsNull(): void
    {
        // Act
        $parsedValue = DateTimeHelper::parseDateTimeObjectFromMixed(null, 'Y-m-d');

        // Assert
        $this->assertNull($parsedValue);
    }

    public function testIfNonDateStringValueReturnsNull(): void
    {
        // Act
        $parsedValue = DateTimeHelper::parseDateTimeObjectFromMixed('non date string', 'Y-m-d');

        // Assert
        $this->assertNull($parsedValue);
    }
}
