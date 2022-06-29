<?php

declare(strict_types=1);

namespace PHPValidation\Strategies;

interface ValidationStrategyInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function validate(array $data): void;

    /**
     * @return array<string>
     */
    public function getErrorMessages(): array;
}
