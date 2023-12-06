<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use stdClass;

use function PHPValidation\Functions\dateLowerEqual;

final class DateLowerEqualFieldTest extends TestCase
{
    public function testIfDateStringWithLowerDateIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '2000-12-30']); // Used format: Y-m-d

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateStringWithEqualDateIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '2000-12-31']); // Used format: Y-m-d

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateStringWithGreaterDateIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-30'), 'Y-m-d');

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '2000-12-31']); // Used format: Y-m-d

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

    public function testIfDateStringWithInvalidFormatIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d');

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '30-12-2000']); // Used format: d-m-Y

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

    public function testIfDateObjectWithLowerDateIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTime::createFromFormat('Y-m-d', '2000-12-30')]); // Used format: Y-m-d

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateObjectWithEqualDateIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTime::createFromFormat('Y-m-d', '2000-12-31')]); // Used format: Y-m-d

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateObjectWithGreaterDateIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-30'), 'Y-m-d');

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTime::createFromFormat('Y-m-d', '2000-12-31')]); // Used format: d-m-Y

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

    public function testIfDateImmutableObjectWithLowerDateIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTimeImmutable::createFromFormat('Y-m-d', '2000-12-30')]); // Used format: Y-m-d

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateImmutableObjectWithEqualDateIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTimeImmutable::createFromFormat('Y-m-d', '2000-12-31')]); // Used format: Y-m-d

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfDateImmutableObjectWithGreaterDateIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = dateLowerEqual(DateTimeImmutable::createFromFormat('Y-m-d', '2000-12-30'), 'Y-m-d');

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => DateTime::createFromFormat('Y-m-d', '2000-12-31')]); // Used format: d-m-Y

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
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'));

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
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'));

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
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'));

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
