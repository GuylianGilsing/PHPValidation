<?php

declare(strict_types=1);

namespace PHPValidation\Strategies;

use PHPValidation\Fields\FieldValidatorInterface;

interface ValidationStrategyInterface
{
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
    public function setValidators(array $validators): void;

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
    public function setCustomErrorMessages(array $messages): void;

    /**
     * @return array<string, string|array<string, mixed>> An infinite associative array
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
    public function getErrorMessages(): array;

    /**
     * @param array<string, mixed> $data
     */
    public function run(array $data): void;

    public function isValid(): bool;
}
