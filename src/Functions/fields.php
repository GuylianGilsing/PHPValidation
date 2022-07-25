<?php

declare(strict_types=1);

namespace PHPValidation\Functions;

use PHPValidation\Fields\FieldValidatorInterface;
use PHPValidation\Fields\RequiredField;

function required(): FieldValidatorInterface
{
    return new RequiredField();
}
