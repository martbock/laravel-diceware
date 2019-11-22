<?php

namespace Martbock\Diceware\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Martbock\Diceware\DicewareClient
 *
 * @method static string generate(int $numberOfWords = null, string $separator = null): string
 */
class Diceware extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-diceware';
    }
}
