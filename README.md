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
        - [in](#in)
        - [minLength](#minlength)
        - [maxLength](#maxlength)
        - [minCount](#mincount)
        - [maxCount](#maxcount)
        - [email](#email)
        - [isNumeric](#isnumeric)
        - [isInt](#isint)
        - [isFloat](#isfloat)
        - [equals](#equals)

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
    - `in` field validator for arrays
    - `minLength` field validator for strings
    - `maxLength` field validator for strings
    - `minCount` field validator for arrays
    - `maxCount` field validator for arrays
    - `email` field validator for strings
    - `isNumeric` field validator for strings, floats, and integers
    - `isInt` field validator for strings and integers
    - `isFloat` field validator for for strings, floats, and integers
    - `equals` field validator for any given data type

## Installation
```bash
$ composer require guyliangilsing/php-validation
```

## Usage
### Obtaining a validator
A validator can be obtained through the `ValidatorBuilder` class:

```php
use PHPValidation\Builders\ValidatorBuilder;

$builder = new ValidatorBuilder();

// Your configuration logic here...

$validator = $builder->build();
```

The validator builder has the following options:

```php
use PHPValidation\Builders\ValidatorBuilder;
use PHPValidation\Strategies\DefaultValidationStrategy;
use PHPValidation\Validator;

use function PHPValidation\Functions\required;

$builder = new ValidatorBuilder();

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
$builder->setStrategy(new DefaultValidationStrategy());

// Registers a new validator class that will be returned when you build the validator
$builder->setValidatorClassName(Validator::class);

$validator = $builder->build();
```

**Note**: The builder already comes preconfigured with a strategy and validator class name, the example above just lists all possible configuration options.

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

$builder = new ValidatorBuilder();

// Your configuration logic here...

$validator = $builder->build();
```

The validator can then be used to validate an array:

```php
use PHPValidation\Builders\ValidatorBuilder;

use function PHPValidation\Functions\required;

$builder = new ValidatorBuilder();

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

$builder = new ValidatorBuilder();

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

$builder = new ValidatorBuilder();

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
When added, and the field exists, it cannot be empty or contain only whitespace. This validator works on both `string` and `array` fields.

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

### in
When added, and the field exists, and the field is of the type `string`, it can only contain one of the stated values.

```php
$builder->setValidators([
    'field' => [in(['option1', 'option2', 'option3'])],
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

### isNumeric
When added, and the field exists, and the field is of the following types: `string`, `float`, `int`, it will check if the given value is numeric.

```php
$builder->setValidators([
    'field' => [isNumeric()],
]);
```

### isInt
When added, and the field exists, and the field is of the following types: `string`, `int`, it will check if the given value can be converted to an integer, and thus is an integer.

```php
$builder->setValidators([
    'field' => [isInt()],
]);
```

### isFloat
When added, and the field exists, and the field is of the following types: `string`, `float`, `int`, it will check if the given value can be converted to a float without losing any data, and thus is an float.

```php
$builder->setValidators([
    'field' => [isFloat()],
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
