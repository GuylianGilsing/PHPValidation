<?php

declare(strict_types=1);

namespace PHPValidation\Functions;

use PHPValidation\Fields\FieldValidatorInterface;
use PHPValidation\Fields\HasValuesField;
use PHPValidation\Fields\InField;
use PHPValidation\Fields\IsArrayField;
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

/**
 * The value of this field must be an array.
 */
function isArray(): FieldValidatorInterface
{
    return new IsArrayField();
}

/**
 * This array field must contain all given values.
 *
 * @param array<mixed> $values An indexed array.
 */
function hasValues(array $values): FieldValidatorInterface
{
    return new HasValuesField($values);
}

/**
 * This array field must contain one of the values within a given array.
 */
function in(array $values)
{
    return new InField($values);
}
