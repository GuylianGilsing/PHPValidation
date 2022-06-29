<?php

declare(strict_types=1);

namespace PHPValidation;

interface ValidatorInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function validate(array $data): void;

    public function isValid(): bool;

    /**
     * @return array<string>
     */
    public function getErrorMessages(): array;
}
