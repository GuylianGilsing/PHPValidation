<?php

declare(strict_types=1);

namespace PHPValidation\Functions;

use PHPValidation\Fields\FieldValidatorInterface;
use PHPValidation\Fields\NotEmptyField;
use PHPValidation\Fields\RequiredField;

/**
 * This field must exist within a given array.
 */
function required(): FieldValidatorInterface
{
    return new RequiredField();
}

/**
 * The value of this field cannot be an empty string or array.
 */
function notEmpty(): FieldValidatorInterface
{
    return new NotEmptyField();
}
