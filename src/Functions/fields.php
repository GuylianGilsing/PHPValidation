<?php

declare(strict_types=1);

namespace PHPValidation\Functions;

use PHPValidation\Fields\EmailField;
use PHPValidation\Fields\FieldValidatorInterface;
use PHPValidation\Fields\HasKeysField;
use PHPValidation\Fields\HasValuesField;
use PHPValidation\Fields\InField;
use PHPValidation\Fields\IsArrayField;
use PHPValidation\Fields\MaxCountField;
use PHPValidation\Fields\MaxLengthField;
use PHPValidation\Fields\MinCountField;
use PHPValidation\Fields\MinLengthField;
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
 * This array field must contain all given keys.
 *
 * @param array<mixed> $keys An indexed array of key names.
 */
function hasKeys(array $keys): FieldValidatorInterface
{
    return new HasKeysField($keys);
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
 *
 * @param array<mixed> $values An indexed array.
 */
function in(array $values): FieldValidatorInterface
{
    return new InField($values);
}

/**
 * The value of this field must contain at least a certain amount of characters.
 */
function minLength(int $length): FieldValidatorInterface
{
    return new MinLengthField($length);
}

/**
 * The value of this field cannot contain more than a certain amount of characters.
 */
function maxLength(int $length): FieldValidatorInterface
{
    return new MaxLengthField($length);
}

/**
 * The value of this array field must contain at least a certain amount of values.
 */
function minCount(int $count): FieldValidatorInterface
{
    return new MinCountField($count);
}

/**
 * The value of this array field cannot contain more than a certain amount of values.
 */
function maxCount(int $count): FieldValidatorInterface
{
    return new MaxCountField($count);
}

/**
 * The value of this field must be an RFC 5322 compliant email address.
 */
function email(): FieldValidatorInterface
{
    return new EmailField();
}
