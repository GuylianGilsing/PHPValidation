<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use PHPValidation\Helpers\RegexHelper;

final class RegexTest extends TestCase
{
    public function testIfSpecialRegexCharactersGetEscapedProperly(): void
    {
        // Arrange
        $specialCharacters = ['.', '^', '$', '*', '+', '?', '(', ')', '[', ']', '{', '}', '\\', '|'];

        // Act
        foreach ($specialCharacters as $specialCharacter)
        {
            $escapedCharacter = RegexHelper::escapeSpecialCharacters($specialCharacter);

            // Assert
            $this->assertEquals('\\'.$specialCharacter, $escapedCharacter);
        }
    }
}
