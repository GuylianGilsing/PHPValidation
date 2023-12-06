<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;

use function PHPValidation\Functions\required;

final class ValidatorTest extends TestCase
{
    public function testIfCanValidateSimpleArray(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [required()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);
    }

    public function testIfErrorsArrayHasCorrectLayout(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [required()],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);

        $expectedErrorLayout = [
            'field1' => [
                required()->getKey() => required()->getErrorMessage(),
            ]
        ];
        $this->assertEquals($expectedErrorLayout, $comments);
    }

    public function testIfCanValidateNestedArrays(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [
                'nestedField1' => [required()],
            ],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([
            'field1' => [],
        ]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);
    }

    public function testIfNestedErrorsArrayHasCorrectLayout(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [
                'nestedField1' => [required()],
            ],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([
            'field1' => [],
        ]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);

        $expectedErrorLayout = [
            'field1' => [
                'nestedField1' => [
                    required()->getKey() => required()->getErrorMessage(),
                ],
            ]
        ];
        $this->assertEquals($expectedErrorLayout, $comments);
    }

    public function testIfCanValidateNestedArrayFromEmptyDataArray(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [
                'nestedField1' => [required()],
            ],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);
    }

    public function testIfNestedErrorsArrayHasCorrectLayoutFromEmptyDataArray(): void
    {
        // Arrange
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [
                'nestedField1' => [required()],
            ],
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);

        $expectedErrorLayout = [
            'field1' => [
                'nestedField1' => [
                    required()->getKey() => required()->getErrorMessage(),
                ],
            ]
        ];
        $this->assertEquals($expectedErrorLayout, $comments);
    }

    public function testIfCanReplaceErrorMessageWithSimpleArray(): void
    {
        // Arrange
        $expectedErrorMessage = "Field must be filled in!";
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [required()],
        ]);

        $builder->setErrorMessages([
            'field1' => [
                required()->getKey() => $expectedErrorMessage,
            ]
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);

        $expectedErrorLayout = [
            'field1' => [
                required()->getKey() => $expectedErrorMessage,
            ]
        ];
        $this->assertEquals($expectedErrorLayout, $comments);
    }

    public function testIfCanReplaceErrorMessageWithNestedArray(): void
    {
        // Arrange
        $expectedErrorMessage = "Field must be filled in!";
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [
                'nestedField1' => [required()],
            ],
        ]);

        $builder->setErrorMessages([
            'field1' => [
                'nestedField1' => [
                    required()->getKey() => $expectedErrorMessage,
                ],
            ]
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid(['field1' => []]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);

        $expectedErrorLayout = [
            'field1' => [
                'nestedField1' => [
                    required()->getKey() => $expectedErrorMessage,
                ],
            ]
        ];
        $this->assertEquals($expectedErrorLayout, $comments);
    }

    public function testIfCanReplaceErrorMessageWithNestedArrayAndEmptyDataArray(): void
    {
        // Arrange
        $expectedErrorMessage = "Field must be filled in!";
        $builder = new ValidatorBuilder(new DefaultValidationStrategy());

        $builder->setValidators([
            'field1' => [
                'nestedField1' => [required()],
            ],
        ]);

        $builder->setErrorMessages([
            'field1' => [
                'nestedField1' => [
                    required()->getKey() => $expectedErrorMessage,
                ],
            ]
        ]);

        $validator = $builder->build();

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $comments = $validator->getErrorMessages();

        $this->assertFalse($isValid);
        $this->assertNotEmpty($comments);

        $expectedErrorLayout = [
            'field1' => [
                'nestedField1' => [
                    required()->getKey() => $expectedErrorMessage,
                ],
            ]
        ];
        $this->assertEquals($expectedErrorLayout, $comments);
    }
}
