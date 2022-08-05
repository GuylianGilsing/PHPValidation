<?php

declare(strict_types=1);

namespace PHPValidation\Functions;

use PHPValidation\Fields\BetweenField;
use PHPValidation\Fields\EmailField;
use PHPValidation\Fields\EqualsField;
use PHPValidation\Fields\FieldValidatorInterface;
use PHPValidation\Fields\GreaterEqualField;
use PHPValidation\Fields\GreaterThanField;
use PHPValidation\Fields\HasKeysField;
use PHPValidation\Fields\HasValuesField;
use PHPValidation\Fields\InField;
use PHPValidation\Fields\IsArrayField;
use PHPValidation\Fields\IsFloatField;
use PHPValidation\Fields\IsIntegerField;
use PHPValidation\Fields\IsNumericField;
use PHPValidation\Fields\LowerEqualField;
use PHPValidation\Fields\LowerThanField;
use PHPValidation\Fields\MaxCountField;
use PHPValidation\Fields\MaxLengthField;
use PHPValidation\Fields\MinCountField;
use PHPValidation\Fields\MinLengthField;
use PHPValidation\Fields\NotEmptyField;
use PHPValidation\Fields\NotInField;
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
 * This array field cannot contain one of the stated values.
 *
 * @param array<mixed> $values An indexed array.
 */
function notIn(array $values): FieldValidatorInterface
{
    return new NotInField($values);
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

/**
 * The value of this field must be numeric.
 */
function isNumeric(): FieldValidatorInterface
{
    return new IsNumericField();
}

/**
 * The value of this field must contain an integer value.
 */
function isInt(): FieldValidatorInterface
{
    return new IsIntegerField();
}

/**
 * The value of this field must contain a floating point value.
 */
function isFloat(): FieldValidatorInterface
{
    return new IsFloatField();
}

/**
 * The value of this field must be equal to the given value.
 */
function equals(mixed $value, bool $strict = false): FieldValidatorInterface
{
    return new EqualsField($value, $strict);
}

/**
 * The value of this field must be greater than the given value.
 */
function greaterThan(int|float $value): FieldValidatorInterface
{
    return new GreaterThanField($value);
}

/**
 * The value of this field must be greater than, or equal to, the given value.
 */
function greaterEqual(int|float $value): FieldValidatorInterface
{
    return new GreaterEqualField($value);
}

/**
 * The value of this field must be lower than the given value.
 */
function lowerThan(int|float $value): FieldValidatorInterface
{
    return new LowerThanField($value);
}

/**
 * The value of this field must be lower than, or equal to, the given value.
 */
function lowerEqual(int|float $value): FieldValidatorInterface
{
    return new LowerEqualField($value);
}

/**
 * The value of this field must be between two given values.
 */
function between(int|float $min, int|float $max): FieldValidatorInterface
{
    return new BetweenField($min, $max);
}
