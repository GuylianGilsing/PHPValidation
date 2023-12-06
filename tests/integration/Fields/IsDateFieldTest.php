<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use stdClass;

use function PHPValidation\Functions\isDate;

final class IsDateFieldTest extends TestCase
{
    public function testIfDateStringIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isDate()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '01-01-2000']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateTimeObjectIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isDate()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => new DateTime()]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateTimeImmutableObjectIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isDate()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => new DateTimeImmutable()]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfNonDateStringIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isDate()],
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
                isDate()->getKey() => isDate()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfArrayIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isDate()],
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
                isDate()->getKey() => isDate()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfRegularObjectIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isDate()],
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
                isDate()->getKey() => isDate()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }
}
