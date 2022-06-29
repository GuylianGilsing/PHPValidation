<?php

declare(strict_types=1);

namespace PHPValidation\Configuration;

use ErrorException;
use PHPValidation\ValidatorInterface;

final class ValidationConfiguration implements ValidationConfigurationInterface
{
    /**
     * @var array<string, array<ValidatorInterface>> $validators
     */
    private array $validators = [];

    /**
     * @param array<string, array<ValidatorInterface>> $validators
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function hasField(string $key): bool
    {
        return array_key_exists($key, $this->validators);
    }

    /**
     * @throws ErrorException If the given key does not exist.
     * @throws ErrorException If the validators array is not in the right format.
     *
     * @return array<ValidatorInterface>
     */
    public function getValidators(string $key): array
    {
        if (!$this->hasField($key))
        {
            throw new ErrorException("Field '".$key."' does not exist within configuration.");
        }

        $this->validateValidatorsArray($this->validators[$key]);
        return $this->validators[$key];
    }

    /**
     * @param array<string, array<ValidatorInterface>> $validators
     *
     * @throws ErrorException If the validators array is not in the right format.
     */
    private function validateValidatorsArray(array $validators): void
    {
        foreach ($validators as $validator)
        {
            if (!($validator instanceof ValidatorInterface))
            {
                throw new ErrorException("Given validator does not implement '".ValidatorInterface::class."'");
            }
        }
    }
}
