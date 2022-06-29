<?php

declare(strict_types=1);

namespace PHPValidation\Configuration;

use PHPValidation\ValidatorInterface;

interface ValidationConfigurationInterface
{
    public function hasField(string $key): bool;

    /**
     * @return array<ValidatorInterface>
     */
    public function getValidators(string $key): array;
}
