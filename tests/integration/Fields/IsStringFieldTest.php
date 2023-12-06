<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use stdClass;

use function PHPValidation\Functions\isString;

final class IsStringFieldTest extends TestCase
{
    public function testIfStringValueIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isString()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '12']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfNumericValueIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isString()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 12]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                isString()->getKey() => isString()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfObjectValueIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isString()],
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
                isString()->getKey() => isString()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfArrayValueIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isString()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => ['1', 2]]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                isString()->getKey() => isString()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfNullValueIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [isString()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => null]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                isString()->getKey() => isString()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }
}
