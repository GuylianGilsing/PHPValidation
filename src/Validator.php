<?php

declare(strict_types=1);

namespace PHPValidation;

use PHPValidation\Strategies\ValidationStrategyInterface;

final class Validator implements ValidatorInterface
{
    private ValidationStrategyInterface $strategy;

    public function __construct(ValidationStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function isValid(array $data): bool
    {
        $this->strategy->run($data);

        return $this->strategy->isValid();
    }

    /**
     * @return array<string, string|array<string, mixed>> $validators
     */
    public function getErrorMessages(): array
    {
        return $this->strategy->getErrorMessages();
    }
}
