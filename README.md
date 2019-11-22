# Laravel-Diceware

This package makes it easy to generate passphrases that are both secure and easy to remember.

It uses [Diceware](http://world.std.com/~reinhold/diceware.html) wordlists and is fully configurable to your needs.

## Usage

It is very easy to generate a random diceware password, simply use the Facade like this:

```php
$passphrase = Diceware::generate();

// returns 'unwind-cosmic-entryway-magnetic-stardust-ligament'
return $passphrase;
```

## Why use it?

For years, we trained everyone to use passwords that are hard for humans to remember but easy for machines to guess.
If you don't want to frustrate your users, you should consider using something like Diceware to generate passphrases
that are easier to remember and to typewrite.

Perhaps, the problem is best explained by this famous xkcd comic:

[![xkcd Password Strength Comic](https://imgs.xkcd.com/comics/password_strength.png)](https://xkcd.com/936/)

## Installation

You can install the package via composer:

```bash
composer require martbock/laravel-diceware
```

## Configuration

You may change the default settings in the [diceware.php config file](config/diceware.php) that will be published to
your Laravel config directory once you install this package. Currently, the following options are supported:

```php
'number_of_words'       => 6,
'separator'             => '-',
'capitalize'            => false,
'wordlist'              => 'english',
'custom_wordlist_path'  => null,
'number_of_dice'        => 5,
```

Of course, you can use your own wordlist, just set the `custom_wordlist_path` accordingly.

## License

The PHP implementation is licensed under the MIT license, see [LICENSE.md](LICENSE.md).

The included wordlists have the following licenses:

- [eff.txt](wordlists/eff.txt) is licensed under CC-BY-3.0 by the Electronic Frontier Foundation.
- [english.txt](wordlists/english.txt) is licensed under CC-BY-3.0 by Arnold G. Reinhold.
- [german.txt](wordlists/german.txt) is licensed under the GNU General Public License by Benjamin Tenne.