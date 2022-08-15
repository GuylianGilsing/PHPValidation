<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use stdClass;

use function PHPValidation\Functions\dateBetween;

final class DateBetweenFieldTest extends TestCase
{
    public function testIfDateStringBetweenMinMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $builder->setValidators([
            'field' => [dateBetween($dateMin, $dateMax, $format)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '2000-12-29']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateStringLowerThanMinIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '2000-12-27']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfDateStringLargerThanMaxIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '2000-12-31']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfDateObjectBetweenMinMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $builder->setValidators([
            'field' => [dateBetween($dateMin, $dateMax, $format)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTime::createFromFormat($format, '2000-12-29')]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateObjectLowerThanMinIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTime::createFromFormat($format, '2000-12-27')]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfDateObjectLargerThanMaxIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTime::createFromFormat($format, '2000-12-31')]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfDateImmutableObjectBetweenMinMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $builder->setValidators([
            'field' => [dateBetween($dateMin, $dateMax, $format)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTimeImmutable::createFromFormat($format, '2000-12-29')]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateImmutableObjectLowerThanMinIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTimeImmutable::createFromFormat($format, '2000-12-27')]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfDateImmutableObjectLargerThanMaxIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTimeImmutable::createFromFormat($format, '2000-12-31')]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfNonDateStringIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'non date time string']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfArrayIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => ['non', 'date', 'string']]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfRegularObjectIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $format = 'Y-m-d';
        $dateMin = DateTime::createFromFormat($format, '2000-12-28');
        $dateMax = DateTime::createFromFormat($format, '2000-12-30');

        $fieldValidator = dateBetween($dateMin, $dateMax, $format);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => new stdClass()]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }
}
