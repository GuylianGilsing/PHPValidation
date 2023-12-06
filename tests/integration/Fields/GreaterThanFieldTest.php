<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use stdClass;

use function PHPValidation\Functions\greaterThan;

final class GreaterThanFieldTest extends TestCase
{
    public function testIfIntegerGreaterThanFieldIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [greaterThan(30)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 31]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfIntegerEqualsFieldIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = greaterThan(30);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 30]);

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

    public function testIfFloatGreaterThanFieldIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [greaterThan(30)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 30.01]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfFloatEqualsFieldIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = greaterThan(30);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 30.00]);

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

    public function testIfStringGreaterThanFieldIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [greaterThan(30)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '31']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfStringEqualsFieldIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = greaterThan(30);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '30']);

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

    public function testIfNonNumericStringFieldIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = greaterThan(30);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'non numeric string']);

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

    public function testIfNonNumericStringWithNumbersFieldIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = greaterThan(30);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'non 12 numeric 12.40 string']);

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

    public function testIfArrayValueIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = greaterThan(30);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => []]);

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

    public function testIfObjectValueIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = greaterThan(30);

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
