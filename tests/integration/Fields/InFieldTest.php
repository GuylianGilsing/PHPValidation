<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;

use function PHPValidation\Functions\in;

final class InFieldTest extends TestCase
{
    public function testIfValueThatIsInArrayIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [in(['value1', 'value2', 'value3'])],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'value1']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfValueThatIsNotInArrayIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = in(['value1', 'value2', 'value3']);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'test']);

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

    public function testIfNonStringValueIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = in(['value1', 'value2', 'value3']);
        $fieldValue = ['non', 'string', 'value'];

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => $fieldValue]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);
        $this->assertIsNotString($fieldValue);

        $expectedErrorStructure = [
            'field' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }
}
