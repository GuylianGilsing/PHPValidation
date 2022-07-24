<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Fixtures\Strategies;

use PHPValidation\Strategies\ValidationStrategyInterface;

final class MockValidationStrategy implements ValidationStrategyInterface
{
    private bool $isValidState = false;

    /**
     * @var array<string, string|array<string, mixed>> $errorMessages
     */
    private array $errorMessages = [];

    public function __construct(bool $isValidState)
    {
        $this->isValidState = $isValidState;
    }

    /**
     * @param array<string, FieldValidatorInterface|array<string, mixed>> $validators
     */
    public function setValidators(array $validators): void
    {
        // Do nothing...
    }

    /**
     * @param array<string, string|array<string, mixed>> $messages
     */
    public function setCustomErrorMessages(array $messages): void
    {
        $this->errorMessages = $messages;
    }

    /**
     * @return array<string, string|array<string, mixed>>
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function run(array $data): void
    {
        // Do nothing...
    }

    public function isValid(): bool
    {
        return $this->isValidState;
    }
}
