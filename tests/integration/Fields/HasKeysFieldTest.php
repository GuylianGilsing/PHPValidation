<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;

use function PHPValidation\Functions\hasKeys;

final class HasKeysFieldTest extends TestCase
{
    public function testIfMatchingArrayIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [hasKeys(['key1', 'key2', 'key3'])],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => [
            'key1' => 'test',
            'key2' => 'test',
            'key3' => 'test',
        ]]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfNotMatchingArrayIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = hasKeys(['key1', 'key2', 'key3']);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => ['value1']]);

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

    public function testIfNonArrayIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $fieldValidator = hasKeys(['key1', 'key2', 'key3']);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'non array']);

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
