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

<!-- /TOC -->

## Features
PHPValidation comes with the following features:

- Array validation through a simple and clean interface
- Custom field validator support
- Built-in field validators for basic use-cases
    - `required` field validator
    - `notEmpty` field validator for strings and arrays
    - `isArray` field validator
    - `hasValues` field validator for arrays
    - `in` field validator for arrays
    - `minLength` field validator for strings
    - `maxLength` field validator for strings

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

It is recommended to create a simple function that wraps your custom validator. PHPValidation has a lot of built-in validators that are being wrapped in the following way:

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

