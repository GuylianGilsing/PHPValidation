<?php

declare(strict_types=1);

namespace PHPValidation\Functions;

use DateTimeInterface;
use PHPValidation\Fields\BetweenField;
use PHPValidation\Fields\ConfirmValuesField;
use PHPValidation\Fields\ContainsField;
use PHPValidation\Fields\DateBetweenField;
use PHPValidation\Fields\DateEqualsField;
use PHPValidation\Fields\DateGreaterEqualField;
use PHPValidation\Fields\DateGreaterThanField;
use PHPValidation\Fields\DateHasFormatField;
use PHPValidation\Fields\DateLowerEqualField;
use PHPValidation\Fields\DateLowerThanField;
use PHPValidation\Fields\EmailField;
use PHPValidation\Fields\EqualsField;
use PHPValidation\Fields\FieldValidatorInterface;
use PHPValidation\Fields\GreaterEqualField;
use PHPValidation\Fields\GreaterThanField;
use PHPValidation\Fields\HasKeysField;
use PHPValidation\Fields\HasValuesField;
use PHPValidation\Fields\InField;
use PHPValidation\Fields\IsAlphabeticField;
use PHPValidation\Fields\IsAlphaNumericField;
use PHPValidation\Fields\IsArrayField;
use PHPValidation\Fields\IsDateField;
use PHPValidation\Fields\IsFloatField;
use PHPValidation\Fields\IsIntegerField;
use PHPValidation\Fields\IsNumericField;
use PHPValidation\Fields\IsObjectField;
use PHPValidation\Fields\IsStringField;
use PHPValidation\Fields\LowerEqualField;
use PHPValidation\Fields\LowerThanField;
use PHPValidation\Fields\MaxCountField;
use PHPValidation\Fields\MaxLengthField;
use PHPValidation\Fields\MinCountField;
use PHPValidation\Fields\MinLengthField;
use PHPValidation\Fields\NotEmptyField;
use PHPValidation\Fields\NotInField;
use PHPValidation\Fields\ObjectOfTypeField;
use PHPValidation\Fields\PhoneNumberField;
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
 * The value of this field must be equal to the value of a specified array key.
 *
 * @param string $keys This key refers to a field within the global validator structure.
 * Use dot notation to reference nested fields:
 * `key1.nestedKey1.nestedKey2` translates to `['key1' => ['nestedKey1' => [nestedKey2 => '']]]`
 */
function confirmValues(string $keys): FieldValidatorInterface
{
    return new ConfirmValuesField($keys);
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
 * The value of this field must be a valid international phone number.
 */
function phoneNumber(): FieldValidatorInterface
{
    return new PhoneNumberField();
}

/**
 * The value of this field can only contain normal, non-special, characters and whitespace.
 */
function isAlphabetic(): FieldValidatorInterface
{
    return new IsAlphabeticField();
}

/**
 * The value of this field must be numeric.
 */
function isNumeric(): FieldValidatorInterface
{
    return new IsNumericField();
}

/**
 * The value of this field can only contain normal, non-special, characters, numbers, and whitespace.
 *
 * @param array<string> $extraCharacters An indexed array of strings that contain characters that can exist
 * within the string.
 */
function isAlphaNumeric(array $extraCharacters = []): FieldValidatorInterface
{
    return new IsAlphaNumericField($extraCharacters);
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
 * The value of this field must contain a string value.
 */
function isString(): FieldValidatorInterface
{
    return new IsStringField();
}

/**
 * The value of this field must contain an object value.
 */
function isObject(): FieldValidatorInterface
{
    return new IsObjectField();
}

/**
 * This value of this field must contain an object that has the desired type.
 *
 * @param string $type The `Class::name` string of the desired type.
 */
function objectOfType(string $type): FieldValidatorInterface
{
    return new ObjectOfTypeField($type);
}

/**
 * The value of this field must be equal to the given value.
 */
function equals(mixed $value, bool $strict = false): FieldValidatorInterface
{
    return new EqualsField($value, $strict);
}

/**
 * This value of this must contain a specific substring.
 */
function contains(string $value): FieldValidatorInterface
{
    return new ContainsField($value);
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

/**
 * The value of this field must be a date string, or an object that implements the `DateTimeInterface` interface.
 */
function isDate(): FieldValidatorInterface
{
    return new IsDateField();
}

/**
 * The value of this field must have the given date format.
 */
function dateHasFormat(string $format): FieldValidatorInterface
{
    return new DateHasFormatField($format);
}

/**
 * The value of this field must be equal to the given date.
 */
function dateEquals(DateTimeInterface $date, string $format = 'Y-m-d H:i:s'): FieldValidatorInterface
{
    return new DateEqualsField($date, $format);
}

/**
 * The value of this field must be lower than the given date.
 */
function dateLowerThan(DateTimeInterface $date, string $format = 'Y-m-d H:i:s'): FieldValidatorInterface
{
    return new DateLowerThanField($date, $format);
}

/**
 * The value of this field must be lower than, or equal to the given date.
 */
function dateLowerEqual(DateTimeInterface $date, string $format = 'Y-m-d H:i:s'): FieldValidatorInterface
{
    return new DateLowerEqualField($date, $format);
}

/**
 * The value of this field must be greater than the given date.
 */
function dateGreaterThan(DateTimeInterface $date, string $format = 'Y-m-d H:i:s'): FieldValidatorInterface
{
    return new DateGreaterThanField($date, $format);
}

/**
 * The value of this field must be greater than, or equal to the given date.
 */
function dateGreaterEqual(DateTimeInterface $date, string $format = 'Y-m-d H:i:s'): FieldValidatorInterface
{
    return new DateGreaterEqualField($date, $format);
}

/**
 * The value of this field must be between two dates.
 */
function dateBetween(
    DateTimeInterface $min,
    DateTimeInterface $max,
    string $format = 'Y-m-d H:i:s'
): FieldValidatorInterface {
    return new DateBetweenField($min, $max, $format);
}
