# PHPValidation
A simple validation library that allows you to write custom validators for your data.

## Table of Contents

<!-- TOC -->

- [PHPValidation](#phpvalidation)
    - [Table of Contents](#table-of-contents)
    - [Features](#features)
    - [Installation](#installation)
    - [Usage](#usage)
        - [Obtaining a validator](#obtaining-a-validator)
            - [Through a factory](#through-a-factory)
        - [Configuring array field validation](#configuring-array-field-validation)
        - [Configuring custom error messages](#configuring-custom-error-messages)
        - [Using the validator](#using-the-validator)
        - [Creating custom field validators](#creating-custom-field-validators)
    - [Available field validators](#available-field-validators)
        - [required](#required)
        - [notEmpty](#notempty)
        - [isArray](#isarray)
        - [hasKeys](#haskeys)
        - [hasValues](#hasvalues)
        - [confirmValues](#confirmvalues)
        - [in](#in)
        - [notIn](#notin)
        - [minLength](#minlength)
        - [maxLength](#maxlength)
        - [minCount](#mincount)
        - [maxCount](#maxcount)
        - [email](#email)
        - [phoneNumber](#phonenumber)
        - [isAlphabetic](#isalphabetic)
        - [isNumeric](#isnumeric)
        - [isAlphaNumeric](#isalphanumeric)
        - [isInt](#isint)
        - [isFloat](#isfloat)
        - [isString](#isstring)
        - [isObject](#isobject)
        - [objectOfType](#objectoftype)
        - [equals](#equals)
        - [contains](#contains)
        - [greaterThan](#greaterthan)
        - [greaterEqual](#greaterequal)
        - [lowerThan](#lowerthan)
        - [lowerEqual](#lowerequal)
        - [between](#between)
        - [isDate](#isdate)
        - [dateHasFormat](#datehasformat)
        - [dateEquals](#dateequals)
        - [dateLowerThan](#datelowerthan)
        - [dateLowerEqual](#datelowerequal)
        - [dateGreaterThan](#dategreaterthan)
        - [dateGreaterEqual](#dategreaterequal)
        - [dateBetween](#datebetween)

<!-- /TOC -->

## Features
PHPValidation comes with the following features:

- Array validation through a simple and clean interface
- Custom field validator support
- Built-in field validators for basic use-cases
    - `required` field validator
    - `notEmpty` field validator for strings and arrays
    - `isArray` field validator
    - `hasKeys` field validator for arrays
    - `hasValues` field validator for arrays
    - `confirmValues` field validator for arrays
    - `in` field validator for strings, floats, integers, booleans, and arrays with the previous types inside of them
    - `notIn` field validator for strings, floats, integers, and booleans
    - `minLength` field validator for strings
    - `maxLength` field validator for strings
    - `minCount` field validator for arrays
    - `maxCount` field validator for arrays
    - `email` field validator for strings
    - `phoneNumber` field validator for strings
    - `isAlphabetic` field validator for strings
    - `isNumeric` field validator for strings, floats, and integers
    - `isAlphaNumeric` field validator for strings
    - `isInt` field validator for strings and integers
    - `isFloat` field validator for strings, floats, and integers
    - `isString` field validator for strings
    - `isObject` field validator for objects
    - `equals` field validator for any given data type
    - `contains` field validator for strings
    - `greaterThan` field validator for numeric strings, floats, and integers
    - `greaterEqual` field validator for numeric strings, floats, and integers
    - `lowerThan` field validator for numeric strings, floats, and integers
    - `lowerEqual` field validator for numeric strings, floats, and integers
    - `between` field validator for numeric strings, floats, and integers
    - `isDate` field validator for date strings and objects that implement the DateTimeInterface interface
    - `dateHasFormat` field validator for date strings and objects that implement the DateTimeInterface interface
    - `dateEquals` field validator for date strings and objects that implement the DateTimeInterface interface
    - `dateLowerThan` field validator for date strings and objects that implement the DateTimeInterface interface
    - `dateLowerEqual` field validator for date strings and objects that implement the DateTimeInterface interface
    - `dateGreaterThan` field validator for date strings and objects that implement the DateTimeInterface interface
    - `dateGreaterEqual` field validator for date strings and objects that implement the DateTimeInterface interface
    - `dateBetween` field validator for date strings and objects that implement the DateTimeInterface interface

## Installation
```bash
$ composer require guyliangilsing/php-validation
```

**IMPORTANT**: PHPValidation requires php version 8 or higher to work properly.

## Usage
### Obtaining a validator
A validator can be obtained through the `ValidatorBuilder` class:

```php
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;

$strategy = new DefaultValidationStrategy();
$builder = new ValidatorBuilder($strategy);

// Your configuration logic here...

$validator = $builder->build();
```

The validator builder has the following options:

```php
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use PHPValidation\Validator;

use function PHPValidation\Functions\required;

$strategy = new DefaultValidationStrategy();
$builder = new ValidatorBuilder($strategy);

// Configures the field validators for each array field
$builder->setValidators([
    'field1' => [required()],
]);

// Configures custom error messages for each array field validator
$builder->setErrorMessages([
    'field1' => [
        required()->getKey() => "My custom error message...",
    ]
]);

// Passes a new validation handler/strategy to the actual validator
$newStrategy = // Your custom strategy here...
$builder->setStrategy($newStrategy);

// Registers a new validator class that will be returned when you build the validator
$builder->setValidatorClassName(Validator::class);

$validator = $builder->build();
```

**Note**: The builder already comes preconfigured with a strategy and validator class name, the example above just lists all possible configuration options.

#### Through a factory
A validator can also be obtained through the default factory:

```php
namespace PHPValidation\Factories\ValidatorFactory;

$factory = new ValidatorFactory();
$validator = $factory->createDefaultValidator();
```

**Note**: Adding more methods to this default factory class is possible by inheriting it.

### Configuring array field validation
Within the validation builder, an array must be set that defines how a given array should be validated. This uses the following structure:

```php
[
    'fieldName' => [FieldValidatorInterface, FieldValidatorInterface, FieldValidatorInterface],
    'nestedField' => [
        'fieldName' => [FieldValidatorInterface, FieldValidatorInterface, FieldValidatorInterface],
    ]
]
```

The structure itself is quite simple. It is just an array that defines the names of the fields through keys, and the field validation through classes that implement the `FieldValidatorInterface` interface. Nested fields are also supported, you just have a key point to an array with the basic key => array\<FieldValidatorInterface\> structure, this can be done infinitely.

### Configuring custom error messages
Each built-in field validator comes with their own default error messages. These messages can be overriden by providing the builder with an array that has the following structure:

```php
[
    'fieldName' => [
        'fieldValidatorKey' => "Your custom error message..."
    ],
    'nestedField' => [
        'fieldName' => [
            'fieldValidatorKey' => "Your custom error message..."
        ],
    ],
]
```
This structure needs a field name key that points to an array that has the field validator key and an error message as a key => value pair. Nested fields are also supported and can be used by wrapping the structure for a singular field, inside an array that gets pointed to by a key.

### Using the validator
Once you have configured the validator builder, the validator can be built by using the `build()` method:

```php
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;

$strategy = new DefaultValidationStrategy();
$builder = new ValidatorBuilder($strategy);

// Your configuration logic here...

$validator = $builder->build();
```

The validator can then be used to validate an array:

```php
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;

use function PHPValidation\Functions\required;

$strategy = new DefaultValidationStrategy();
$builder = new ValidatorBuilder($strategy);

$builder->setValidators([
    'field1' => [required()],
]);

$validator = $builder->build();

$isValid = $validator->isValid([]); // Will return false
$errorMessages = $validator->getErrorMessages(); // Will return error messages
```

### Creating custom field validators
Creating a custom field validator is quite easy. The only thing you have to do is implement the `FieldValidatorInterface` interface:

```php
declare(strict_types=1);

namespace PHPValidation\Fields;

final class RequiredField implements FieldValidatorInterface
{
    // Is used by the validation strategy and will skip this validator if it needs an existing field
    public function fieldNeedsToExist(): bool
    {
        return false;
    }

    // The unique key for this validator
    public function getKey(): string
    {
        return 'required';
    }

    // Your validation logic goes here...
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        return $fieldExists;
    }

    // Your default error message goes here...
    public function getErrorMessage(): string
    {
        return 'This field is required';
    }
}
```

It is recommended to create a simple function that wraps your custom validator. PHPValidation comes with some basic built-in validators that are being wrapped in the following way:

```php
declare(strict_types=1);

namespace PHPValidation\Functions;

use PHPValidation\Fields\FieldValidatorInterface;
use PHPValidation\Fields\RequiredField;

function required(): FieldValidatorInterface
{
    return new RequiredField();
}
```

Wrapping your custom validator with a function will prevent the following code from being written:

```php
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use PHPValidation\Validator;

$strategy = new DefaultValidationStrategy();
$builder = new ValidatorBuilder($strategy);

$builder->setValidators([
    'field1' => [new RequiredField(), new CustomValidator()],
]);

$validator = $builder->build();
```

And makes the final code easier to read:

```php
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use PHPValidation\Validator;

use function PHPValidation\Functions\required;

$strategy = new DefaultValidationStrategy();
$builder = new ValidatorBuilder($strategy);

$builder->setValidators([
    'field1' => [required(), custom_validator()],
]);

$validator = $builder->build();
```

## Available field validators
PHPValidation comes with some built-in field validators that should cover basic use cases.

### required
When added, this field key must be present in an array.

```php
$builder->setValidators([
    'field' => [required()],
]);
```

### notEmpty
When added, and the field exists, and the field is of the type `string` or `array`, it cannot be empty or contain only whitespace.

```php
$builder->setValidators([
    'field' => [notEmpty()],
]);
```

### isArray
When added, and the field exists, it must be of the type `array`.

```php
$builder->setValidators([
    'field' => [isArray()],
]);
```

### hasKeys
When added, and the field exists, and the field is of the type `array`, it must have all of the stated keys.

```php
$builder->setValidators([
    'field' => [hasKeys('key1', 'key2', 'key3')],
]);
```

### hasValues
When added, and the field exists, and the field is of the type `array`, it must have all of the stated values.

```php
$builder->setValidators([
    'field' => [hasValues(['value1', 'value2', 'value3'])],
]);
```

### confirmValues
When added, and the field exists, the field value must be equal to the value of another field. When specifying which array field value the current field must match, dot notation is used to denote the key tree: `key1.nestedKey1` translates to the following php array:

```php
[
    'key1' => [
        'nestedKey1' => // YOUR VALUE HERE...
    ],
]
```

```php
$builder->setValidators([
    'field1' => [confirmValues('field2')], // Targets the key on the first array level
    'field2' => [confirmValues('field2.nestedField1')], // Targets the key on the second array level
]);
```

### in
When added, and the field exists, and the field is of the type `string`, `int`, `float`, `bool`, or `array`, it can only contain one of the stated values.

**Note**: When this validator has an array value passed to it, it will only validate the first level of the array.

```php
$builder->setValidators([
    'field' => [in(['option1', 'option2', 'option3'])],
]);
```

### notIn
When added, and the field exists, and the field is of the type `string`, `int`, `float`, or `bool`, it cannot contain one of the stated values.

```php
$builder->setValidators([
    'field' => [notIn(['option1', 'option2', 'option3'])],
]);
```

### minLength
When added, and the field exists, and the field is of the type `string`, it must have a minimum amount of characters.

```php
$builder->setValidators([
    'field' => [minLength(5)],
]);
```

### maxLength
When added, and the field exists, and the field is of the type `string`, it cannot have more than a certain amount of characters.

```php
$builder->setValidators([
    'field' => [maxLength(10)],
]);
```

### minCount
When added, and the field exists, and the field is of the type `array`, it must have a minimum amount of values.

```php
$builder->setValidators([
    'field' => [minCount(2)],
]);
```

### maxCount
When added, and the field exists, and the field is of the type `array`, it cannot have more than a certain amount of values.

```php
$builder->setValidators([
    'field' => [maxCount(4)],
]);
```

### email
When added, and the field exists, and the field is of the type `string`, it will check for an RFC 5322 compliant email address.

```php
$builder->setValidators([
    'field' => [email()],
]);
```

### phoneNumber
When added, and the field exists, and the field is of the type `string`, it will check for a valid international phone number.

**Note**: This validator does not accept phone numbers delimitted by any characters and/or whitespace.<br/>
**Note**: It probably will be better to create your own phone number validator since a phone number can differ greatly depending on the country/location.

```php
$builder->setValidators([
    'field' => [phoneNumber()],
]);
```

### isAlphabetic
When added, and the field exists, and the field is of the type `string`, it will check if its value only contains normal, non-special, characters and whitespace.

```php
$builder->setValidators([
    'field' => [isAlphabetic()],
]);
```

### isNumeric
When added, and the field exists, and the field is of the following types: `string`, `float`, or `int`, it will check if the given value is numeric.

```php
$builder->setValidators([
    'field' => [isNumeric()],
]);
```

### isAlphaNumeric
When added, and the field exists, and the field is of the type `string`, it will check if the given value only contains normal, non-special, characters, numbers, and whitespace. The validator also supports whitelisting extra characters.

```php
$builder->setValidators([
    'normalField' => [isAlphaNumeric()],
    'extraField' => [isAlphaNumeric(['.', ',', '\\', '[', ']'])], // Whitelists each individual character within the array
]);
```

### isInt
When added, and the field exists, and the field is of the following types: `string` or `int`, it will check if the given value can be converted to an integer, and thus is an integer.

```php
$builder->setValidators([
    'field' => [isInt()],
]);
```

### isFloat
When added, and the field exists, and the field is of the following types: `string`, `float`, or `int`, it will check if the given value can be converted to a float without losing any data, and thus is an float.

```php
$builder->setValidators([
    'field' => [isFloat()],
]);
```

### isString
When added, and the field exists, it will check if the given value is of the type `string`.

```php
$builder->setValidators([
    'field' => [isString()],
]);
```

### isObject
When added, and the field exists, it will check if the given value is of the type `object`.

```php
$builder->setValidators([
    'field' => [isObject()],
]);
```

### objectOfType
When added, and the field exists, and the field is of the type `object`, it will check if the given value has a desired object type.

```php
$builder->setValidators([
    'field' => [objectOfType(DateTime::clas)],
]);
```

### equals
When added, and the field exists, it will check if the given value matches the field value. This validator supports strict and non-strict value validation.

```php
$builder->setValidators([
    'nonStrictField' => [equals('non-strict', false)],
    'strictField' => [equals('strict', true)],
]);
```

### contains
When added, and the field exists, and the field is of the type `string`, it will check if the given value contains a specific substring.

```php
$builder->setValidators([
    'field' => [contains('substring')],
]);
```

### greaterThan
When added, and the field exists, and the field is of the following types: `string`, `float`, or `int`, it will check if the given value is greater than the field value.

```php
$builder->setValidators([
    'field' => [greaterThan(30)],
]);
```

### greaterEqual
When added, and the field exists, and the field is of the following types: `string`, `float`, or `int`, it will check if the given value is greater than, or equal to, the field value.

```php
$builder->setValidators([
    'field' => [greaterEqual(30)],
]);
```

### lowerThan
When added, and the field exists, and the field is of the following types: `string`, `float`, or `int`, it will check if the given value is lower than the field value.

```php
$builder->setValidators([
    'field' => [lowerThan(30)],
]);
```

### lowerEqual
When added, and the field exists, and the field is of the following types: `string`, `float`, or `int`, it will check if the given value is lower than, or equal to, the field value.

```php
$builder->setValidators([
    'field' => [lowerEqual(30)],
]);
```

### between
When added, and the field exists, and the field is of the following types: `string`, `float`, or `int`, it will check if the given value is between two given values.

```php
$builder->setValidators([
    'field' => [between(0, 100)],
]);
```

### isDate
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the field is a date string or an object that implements the `DateTimeInterface` interface.

**Note**: This field uses php's `strtotime()` function to check if a string is indeed a date string.

```php
$builder->setValidators([
    'field' => [isDate()],
]);
```

### dateHasFormat
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the field uses a given php datetime format.

**Note**: It is recommended to only use this validator with date strings. Objects that implement the `DateTimeInterface` interface will always be valid since they are internally cast back to a string with the given format.

```php
$builder->setValidators([
    'field' => [dateHasFormat('Y-m-d')],
]);
```

### dateEquals
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the field value is equal to a pre-determined date object.

```php
$builder->setValidators([
    'field' => [dateEquals(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
]);
```

### dateLowerThan
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the given value is lower than the field value.

```php
$builder->setValidators([
    'field' => [dateLowerThan(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
]);
```

### dateLowerEqual
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the given value is lower than, or equal to, the field value.

```php
$builder->setValidators([
    'field' => [dateLowerEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
]);
```

### dateGreaterThan
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the given value is greater than the field value.

```php
$builder->setValidators([
    'field' => [dateGreaterThan(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
]);
```

### dateGreaterEqual
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the given value is greater than, or equal to, the field value.

```php
$builder->setValidators([
    'field' => [dateGreaterEqual(DateTime::createFromFormat('Y-m-d', '2000-12-31'), 'Y-m-d')],
]);
```

### dateBetween
When added, and the field exists, and the field is of the following type `string` or implements the `DateTimeInterface` interface, it will check if the given value is between two given dates.

```php
$dateMin = DateTime::createFromFormat('Y-m-d', '2000-12-29');
$dateMax = DateTime::createFromFormat('Y-m-d', '2000-12-30');

$builder->setValidators([
    'field' => [dateBetween($dateMin, $dateMax, 'Y-m-d')],
]);
```
