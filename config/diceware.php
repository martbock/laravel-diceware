<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Number of Words per Passphrase
    |--------------------------------------------------------------------------
    |
    | This value determines how many words a diceware generated passphrase
    | will contain if no specific number of words is supplied when invoking
    | the `generate` method on the Diceware facade.
    |
    */

    'number_of_words' => 6,

    /*
    |--------------------------------------------------------------------------
    | Separator
    |--------------------------------------------------------------------------
    |
    | This value determines which separator is used to separate the individual
    | words in your passphrase if no specific separator is supplied when
    | invoking the `generate` method on the Diceware facade. To not use a
    | separator, simply set this value to an empty string.
    |
    */

    'separator' => '-',

    /*
    |--------------------------------------------------------------------------
    | Capitalize
    |--------------------------------------------------------------------------
    |
    | If you want to capitalize each individual word in your passphrase,
    | set this option to `true`.
    |
    */

    'capitalize' => false,

    /*
    |--------------------------------------------------------------------------
    | Wordlist
    |--------------------------------------------------------------------------
    |
    | Here you may choose which of the included wordlists you want to use.
    | If you set the `custom_wordlist.wordlist_path` option to a value other
    | than null, the value of `wordlist` will be ignored.
    | Supported values: 'english', 'eff', 'german'
    |
    */

    'wordlist' => 'english',

    /*
    |--------------------------------------------------------------------------
    | Custom Wordlist
    |--------------------------------------------------------------------------
    |
    | If you want to use your own wordlist, you may set this option to
    | the absolute path of your wordlist file.
    | The `wordlist` option will be ignored.
    | Example: __DIR__ . '../wordlists/foobar.txt'
    |
    */

    'custom_wordlist_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Number of Dice
    |--------------------------------------------------------------------------
    |
    | If you want to use a wordlist that supports a different number of dice
    | than the included wordlists (they all use 5 dice),
    | you may also change that value.
    |
    */

    'number_of_dice' => 5,

];
