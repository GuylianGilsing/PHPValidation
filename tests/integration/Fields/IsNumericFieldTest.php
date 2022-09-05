<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;

use function PHPValidation\Functions\isNumeric;

final class IsNumericFieldTest extends TestCase
{
    public function testIfNumericFloatStringIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isNumeric()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '12.40']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfNumericIntStringIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isNumeric()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '12']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfFloatIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isNumeric()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 12.40]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfIntIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isNumeric()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 12]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfNonNumericStringIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isNumeric()],
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
                isNumeric()->getKey() => isNumeric()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfNonNumericStringWithNumbersIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isNumeric()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'non 12 numeric 12.40 string 12.12.12']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                isNumeric()->getKey() => isNumeric()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }
}
