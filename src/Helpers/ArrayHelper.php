<?php

declare(strict_types=1);

namespace PHPValidation\Helpers;

use ErrorException;

final class ArrayHelper
{
    /**
     * Converts a string like this: `key1.nestedKey1` to an array like this: `['key1', 'nestedKey1']`
     *
     * @return array<string>
     */
    public static function convertDotNotationToKeysArray(string $dotNotation): array
    {
        if (strlen($dotNotation) === 0)
        {
            return [];
        }

        $keys = explode('.', $dotNotation);

        if (!is_array($keys))
        {
            return [];
        }

        return $keys;
    }

    /**
     * Retrieves the value of a key by using an indexed array that defines the path to the key.
     *
     * @param array<string> $keysArray Used to traverse each level of a potential multidimensional array.
     * @param array<mixed> $arrayWithValues The array that holds the value that needs to be retrieved.
     *
     * @throws ErrorException When an empty keys array is given
     * @throws ErrorException When any key within the keys array does not exist.
     */
    public static function getArrayValue(array $keysArray, array $arrayWithValues): mixed
    {
        $keysToRetrieveCount = count($keysArray);

        if ($keysToRetrieveCount === 0)
        {
            throw new ErrorException('Keys array is empty.');
        }

        $currentKeyIndex = 0;
        $retrievedValue = null;
        $currentArrayLevel = $arrayWithValues;

        foreach ($keysArray as $keyToRetrieve)
        {
            $currentKeyIndex += 1;

            if (!array_key_exists($keyToRetrieve, $currentArrayLevel))
            {
                throw new ErrorException('Key "'.$keyToRetrieve.'" does not exist within the given array.');
            }

            if ($currentKeyIndex !== $keysToRetrieveCount)
            {
                $currentArrayLevel = $currentArrayLevel[$keyToRetrieve];
                continue;
            }

            $retrievedValue = $currentArrayLevel[$keyToRetrieve];
        }

        return $retrievedValue;
    }
}
