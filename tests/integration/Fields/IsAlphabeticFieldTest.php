<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use stdClass;

use function PHPValidation\Functions\isAlphabetic;

final class IsAlphabeticFieldTest extends TestCase
{
    public function testIfAlphabeticStringWithoutWhitespaceIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'abcdefghijklmnopqrstuvwxyz']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfAlphabeticStringWithWhitespaceIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'abc def ghi jkl mno pqr stuv wxy z']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfStringWithSpecialCharactersIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'wïth spéciäl cháractürs']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                isAlphabetic()->getKey() => isAlphabetic()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfStringWithNumbersIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'str1ng w1th numb3rs']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                isAlphabetic()->getKey() => isAlphabetic()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfNumbersAreInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
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
                isAlphabetic()->getKey() => isAlphabetic()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfArraysAreInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
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
                isAlphabetic()->getKey() => isAlphabetic()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfObjectsAreInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
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
                isAlphabetic()->getKey() => isAlphabetic()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfNULLValuesAreInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [isAlphabetic()],
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
                isAlphabetic()->getKey() => isAlphabetic()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }
}
