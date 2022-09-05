<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use stdClass;

use function PHPValidation\Functions\between;

final class BetweenFieldTest extends TestCase
{
    public function testIfIntegerBetweenMinMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 50]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfIntegerMinIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 0]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfIntegerMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 100]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfIntegerUnderMinIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => -1]);

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

    public function testIfIntegerOverMaxIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 101]);

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

    public function testIfFloatBetweenMinMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 50.50]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfFloatMinIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 0.00]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfFloatMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 100.00]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfFloatUnderMinIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => -0.01]);

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

    public function testIfFloatOverMaxIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 100.01]);

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

    public function testIfStringBetweenMinMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '50']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfStringMinIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '0']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfStringMaxIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [between(0, 100)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '100']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfStringUnderMinIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '-0.01']);

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

    public function testIfStringOverMaxIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => '100.01']);

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
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

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
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

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
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

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
        $builder = new ValidatorBuilder();

        $fieldValidator = between(0, 100);

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
