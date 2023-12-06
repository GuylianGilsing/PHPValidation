<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;

use function PHPValidation\Functions\minCount;

final class MinCountFieldTest extends TestCase
{
    public function testIfFieldWithMoreThanMinCountIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [minCount(3)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => ['1', '2', '3', '4', '5']]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfFieldWithExactMinCountIsValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field' => [minCount(3)],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => ['1', '2', '3']]);

        // Assert
        $errorMessages = $validator->getErrorMessages();

        $this->assertTrue($isValid);
        $this->assertEmpty($errorMessages);
    }

    public function testIfFieldWithLowerMinCountIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = minCount(3);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => ['1', '2']]);

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

    public function testIfNonArrayFieldIsInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $fieldValidator = minCount(5);

        $builder->setValidators([
            'field' => [$fieldValidator],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field' => 'non array field']);

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
