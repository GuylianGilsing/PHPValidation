<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Unit\Builders;

use ErrorException;
use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidationBuilder;
use PHPValidation\Tests\Fixtures\NonRequiredValidator;
use PHPValidation\Tests\Fixtures\Strategies\MockValidationStrategy;
use PHPValidation\ValidatorInterface;
use stdClass;

final class ValidationBuilderTest extends TestCase
{
    public function testIfCanSetValidationStrategy(): void
    {
        // Arrange
        $strategy = new MockValidationStrategy(false);
        $builder = new ValidationBuilder();

        // Act
        $builder->setStrategy($strategy);

        // Assert
        $validator = $builder->build();

        $this->assertNotNull($validator);
        $this->assertInstanceOf(ValidatorInterface::class, $validator);
    }

    public function testIfCannotSetNonRequiredClass(): void
    {
        // Arrange
        $builder = new ValidationBuilder();

        // Assert
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessageMatches("~Class '(.*)' does not exist\.~");

        // Act
        $builder->setValidatorClassName(NonRequiredValidator::class);
    }

    public function testIfCannotSetNonValidatorInterfaceClass(): void
    {
        // Arrange
        $builder = new ValidationBuilder();

        // Assert
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            "Class '".stdClass::class."' does not implement the '".ValidatorInterface::class."' interface."
        );

        // Act
        $builder->setValidatorClassName(stdClass::class);
    }
}
