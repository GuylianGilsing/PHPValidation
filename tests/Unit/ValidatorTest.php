<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPValidation\Strategies\ValidationStrategyInterface;
use PHPValidation\Tests\Fixtures\Strategies\MockValidationStrategy;
use PHPValidation\Validator;
use PHPValidation\ValidatorInterface;

final class ValidatorTest extends TestCase
{
    public function testIfValidatorIsSetCorrectly(): void
    {
        // Arrange
        $strategy = new MockValidationStrategy(false);
        $validator = $this->getValidatorWithManualStrategy($strategy);

        // Act
        $isValid = $validator->isValid([]);

        // Assert
        $this->assertFalse($isValid);
    }

    private function getValidatorWithManualStrategy(ValidationStrategyInterface $strategy): ValidatorInterface
    {
        return new Validator($strategy);
    }

    private function getValidator(bool $isValidState = true): ValidatorInterface
    {
        $strategy = new MockValidationStrategy($isValidState);

        return new Validator($strategy);
    }
}
