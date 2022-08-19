<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Unit\Helpers;

use ErrorException;
use PHPUnit\Framework\TestCase;
use PHPValidation\Helpers\ArrayHelper;

final class ArrayHelperTest extends TestCase
{
    public function testIfDotNotationConvertsToIndexedArray(): void
    {
        // Arrange
        $dotNotationString = 'key1.key2.key3';

        // Act
        $keys = ArrayHelper::convertDotNotationToKeysArray($dotNotationString);

        // Assert
        $this->assertNotEmpty($keys);
        $this->assertCount(3, $keys);

        $this->assertEquals($keys[0], 'key1');
        $this->assertEquals($keys[1], 'key2');
        $this->assertEquals($keys[2], 'key3');
    }

    public function testIfDotNotationWithoutDotsConvertsToIndexedArray(): void
    {
        // Arrange
        $dotNotationString = 'key1';

        // Act
        $keys = ArrayHelper::convertDotNotationToKeysArray($dotNotationString);

        // Assert
        $this->assertNotEmpty($keys);
        $this->assertCount(1, $keys);

        $this->assertEquals($keys[0], 'key1');
    }

    public function testIfEmptyDotNotationStringConvertsToEmptyArray(): void
    {
        // Arrange
        $dotNotationString = '';

        // Act
        $keys = ArrayHelper::convertDotNotationToKeysArray($dotNotationString);

        // Assert
        $this->assertEmpty($keys);
    }

    public function testIfArrayValueCanBeRetrieved(): void
    {
        // Arrange
        $valueThatNeedsToBeRetrieved = 'retrieve me!';

        $keysTree = ArrayHelper::convertDotNotationToKeysArray('key1.key2.key3');
        $dataArray = [
            'key1' => [
                'key2' => [
                    'key3' => $valueThatNeedsToBeRetrieved
                ],
            ],
        ];

        // Act
        $retrievedValue = ArrayHelper::getArrayValue($keysTree, $dataArray);

        // Assert
        $this->assertIsString($retrievedValue);
        $this->assertNotEmpty($retrievedValue);

        $this->assertEquals($valueThatNeedsToBeRetrieved, $retrievedValue);
    }

    public function testIfSingleDimensionArrayValueCanBeRetrieved(): void
    {
        // Arrange
        $valueThatNeedsToBeRetrieved = 'retrieve me!';

        $keysTree = ArrayHelper::convertDotNotationToKeysArray('key1');
        $dataArray = [
            'key1' => $valueThatNeedsToBeRetrieved,
        ];

        // Act
        $retrievedValue = ArrayHelper::getArrayValue($keysTree, $dataArray);

        // Assert
        $this->assertIsString($retrievedValue);
        $this->assertNotEmpty($retrievedValue);

        $this->assertEquals($valueThatNeedsToBeRetrieved, $retrievedValue);
    }

    public function testIfEmptyKeysArrayThrowsException(): void
    {
        // Assert
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage('Keys array is empty.');

        // Act
        ArrayHelper::getArrayValue([], []);
    }

    public function testIfMissingKeyThrowsException(): void
    {
        // Assert
        $this->expectException(ErrorException::class);

        // Act
        ArrayHelper::getArrayValue(['missingKey'], []);
    }
}
