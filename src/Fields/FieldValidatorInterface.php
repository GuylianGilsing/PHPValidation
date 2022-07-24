<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

interface FieldValidatorInterface
{
    public function getKey(): string;
    public function isValid(bool $fieldExists, mixed $data): bool;
    public function getErrorMessage(): string;
}
