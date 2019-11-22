<?php

namespace Martbock\Diceware\Exceptions;

use Exception;

class WordlistInvalidException extends Exception
{
    public static function wordNotFound(string $dicedNumber)
    {
        return new static("The diceware wordlist does not contain a word for the diced number `{$dicedNumber}`.");
    }

    public static function notParsable(string $line)
    {
        return new static("The line `{$line}` from the diceware wordlist cannot be parsed.");
    }
}
