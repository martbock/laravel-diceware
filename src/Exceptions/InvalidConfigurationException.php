<?php

namespace Martbock\Diceware\Exceptions;

use Exception;

class InvalidConfigurationException extends Exception
{
    public static function numberOfWords()
    {
        return new static("The `number_of_words` diceware option must be an integer.");
    }

    public static function separator()
    {
        return new static("The `separator` diceware option must be a string.");
    }

    public static function capitalize()
    {
        return new static("The `capitalize` diceware option must be a boolean.");
    }

    public static function wordlist()
    {
        return new static("The selected diceware wordlist is invalid.");
    }

    public static function wordlistPath(string $path)
    {
        return new static("The diceware wordlist at `{$path}` is not readable.");
    }
}
