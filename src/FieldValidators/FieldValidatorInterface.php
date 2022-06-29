<?php

declare(strict_types=1);

namespace PHPValidation\FieldValidators;

interface FieldValidatorInterface
{
    public function isValid(mixed $data): bool;
    public function getErrorMessage(): string;
}
