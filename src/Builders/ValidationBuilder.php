<?php

declare(strict_types=1);

namespace PHPValidation\Builders;

use ErrorException;
use PHPValidation\Strategies\ValidationStrategyInterface;
use PHPValidation\Validator;
use PHPValidation\ValidatorInterface;

final class ValidationBuilder
{
    private ValidationStrategyInterface $strategy;
    private string $validatorClassName = Validator::class;

    /**
     * @var array<string, FieldValidatorInterface|array<string, mixed>> $validators An infinite associative array
     * where each level has a key => FieldValidatorInterface pair.
     */
    private array $validators = [];

    /**
     * @var array<string, string|array<string, mixed>> $errorMessages An infinite associative array
     * where each field has a key => string pair that displays a custom error message.
     */
    private array $errorMessages = [];

    /**
     * @param array<string, FieldValidatorInterface|array<string, mixed>> $validators An infinite associative array
     * where each level has a key => FieldValidatorInterface pair.
     * ```
     * [
     *     'field1' => [required(), notEmpty(), minLength(6), maxLength(32)],
     *     'nestedField' => [
     *         'field1' => [isNumber(), between(4, 21)],
     *     ],
     * ]
     * ```
     */
    public function setValidators(array $validators): void
    {
        $this->validators = $validators;
    }

    /**
     * @param array<string, string|array<string, mixed>> $messages An infinite associative array
     * where each field has a key => string pair that displays a custom error message.
     * ```
     * [
     *     'field1' => [
     *         'required' => "Field1 is required",
     *         'notEmpty' => "Field1 must be filled in",
     *         'minLength' => "Field1 must be at least 6 characters long",
     *         'maxLength' => "Field1 cannot be longer than 32 characters",
     *     ],
     *     'nestedField' => [
     *         'field1' => [
     *             'isNumber' => "Field1 must be a number",
     *             'between' => "Field1 must be between 4 and 21",
     *         ],
     *     ],
     * ]
     * ```
     */
    public function setErrorMessages(array $messages): void
    {
        $this->errorMessages = $messages;
    }

    /**
     * Sets a new validator type through a `MyClass::name` string.
     *
     * @throws ErrorException if the given class name does not exist.
     * @throws ErrorException if the given class name does not implement the `ValidatorInterface` interface.
     */
    public function setValidatorClassName(string $className): void
    {
        if (!class_exists($className))
        {
            throw new ErrorException("Class '".$className."' does not exist.");
        }

        if (!$this->givenClassNameImplementsValidatorInterface($className))
        {
            throw new ErrorException(
                "Class '".$className."' does not implement the '".ValidatorInterface::class."' interface."
            );
        }

        $this->validatorClassName = $className;
    }

    public function setStrategy(ValidationStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function build(): ValidatorInterface
    {
        $this->strategy->setValidators($this->validators);
        $this->strategy->setCustomErrorMessages($this->errorMessages);

        return new $this->validatorClassName($this->strategy);
    }

    private function givenClassNameImplementsValidatorInterface(string $className): bool
    {
        $implementedInterfaces = class_implements($className);

        if (!is_array($implementedInterfaces))
        {
            return false;
        }

        return in_array(ValidatorInterface::class, $implementedInterfaces);
    }
}
