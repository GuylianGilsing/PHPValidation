<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;

use function PHPValidation\Functions\required;

final class RequiredFieldTest extends TestCase
{
    public function testIfExistingFieldIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [required()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'test']);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfNonExistingFieldIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [required()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($errorMessages);

        $expectedErrorStructure = [
            'field' => [
                required()->getKey() => required()->getErrorMessage()
            ]
        ];

        $this->assertEquals($expectedErrorStructure, $errorMessages);
    }
}
