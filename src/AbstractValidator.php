<?php

declare(strict_types=1);

namespace PHPValidation;

use PHPValidation\Configuration\ValidationConfigurationInterface;
use PHPValidation\Strategies\ValidationStrategyInterface;

abstract class AbstractValidator implements ValidatorInterface
{
    private ValidationConfigurationInterface $configuration;
    private ValidationStrategyInterface $validationStrategy;

    /**
     * @var array<string> $errorMessages
     */
    private array $errorMessages = [];

    public function __construct()
    {
        $this->configuration = $this->getConfiguration();
        $this->validationStrategy = $this->getValidationStrategy($this->configuration);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function validate(array $data): void
    {
        $this->validationStrategy->validate($data);
        $this->errorMessages = $this->validationStrategy->getErrorMessages();
    }

    public function isValid(): bool
    {
        return count($this->errorMessages) === 0;
    }

    /**
     * @return array<string>
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    abstract protected function getConfiguration(): ValidationConfigurationInterface;
    abstract protected function getValidationStrategy(
        ValidationConfigurationInterface $validationConfigurationInterface
    ): ValidationStrategyInterface;
}
