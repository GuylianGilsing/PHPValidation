<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use ErrorException;
use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;

use function PHPValidation\Functions\confirmValues;

final class ConfirmValuesFieldTest extends TestCase
{
    public function testIfMatchingFieldValuesAreValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field1' => [confirmValues('field2')],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([
            'field1' => 'same string',
            'field2' => 'same string',
        ]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfNonMatchingFieldValuesAreInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = confirmValues('field2');

        $builder->setValidators([
            'field1' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([
            'field1' => 'same string',
            'field2' => 'different string',
        ]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field1' => [
                $fieldValidator->getKey() => $fieldValidator->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }

    public function testIfNonExistingKeyThrowsException(): void
    {
        // Assert
        $this->expectException(ErrorException::class);

        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = confirmValues('field3');

        $builder->setValidators([
            'field1' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $validator->isValid([
            'field1' => 'same string',
            'field2' => 'different string',
        ]);
    }
}
