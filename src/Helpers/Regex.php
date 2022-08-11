<?php

declare(strict_types=1);

namespace PHPValidation\Helpers;

final class Regex
{
    /**
     * Escapes the following special characters: `.` `^` `$` `*` `+` `?` `(` `)` `[` `]` `{` `}` `\` `|`
     */
    public static function escapeSpecialCharacters(string $character): string
    {
        switch ($character)
        {
            case '.':
            case '^':
            case '$':
            case '*':
            case '+':
            case '?':
            case '(':
            case ')':
            case '[':
            case ']':
            case '{':
            case '}':
            case '\\':
            case '|':
                return '\\'.$character;
                break;
        }

        return $character;
    }
}
