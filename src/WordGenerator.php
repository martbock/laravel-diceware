<?php

namespace Martbock\Diceware;

use Illuminate\Support\Facades\File;
use Martbock\Diceware\Exceptions\InvalidConfigurationException;
use Martbock\Diceware\Exceptions\WordlistInvalidException;
use function array_push;
use function fclose;
use function feof;
use function fgets;
use function fopen;
use function implode;
use function preg_match;
use function random_int;
use function strpos;
use function strval;
use function ucfirst;

class WordGenerator
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Generate a cryptographically secure integer between 1 and 6.
     *
     * @throws \Exception Thrown if there is not enough entropy.
     *
     * @return int
     */
    public function rollDice(): int
    {
        return random_int(1, 6);
    }

    /**
     * Generate a number that can be looked up in a diceware wordlist.
     *
     * @throws \Exception Thrown if there is not enough entropy.
     *
     * @return string
     */
    public function generateDicedNumber(): string
    {
        $result = '';

        for ($i = 0; $i < $this->getNumberOfDice(); $i++) {
            $result .= strval($this->rollDice());
        }

        return $result;
    }

    /**
     * Get the number of dice to use to generate a diced number.
     *
     * @return int
     */
    public function getNumberOfDice(): int
    {
        return $this->config['number_of_dice'];
    }

    /**
     * Get the absolute file path of the wordlist to use.
     *
     * @return string
     */
    public function getWordlistPath(): string
    {
        return $this->config['custom_wordlist_path'] ?: __DIR__.'/../wordlists/'.$this->config['wordlist'].'.txt';
    }

    /**
     * Parse the word from the provided wordlist line.
     *
     * @param string $line
     *
     * @throws WordlistInvalidException
     *
     * @return mixed
     */
    public function parseWord(string $line): string
    {
        $parts = [];
        preg_match('/^[1-6]+\s+(.+)$/', $line, $parts);
        if (count($parts) !== 2) {
            throw WordlistInvalidException::notParsable($line);
        }

        return $parts[1];
    }

    /**
     * Get the diced word from the wordlist.
     *
     * @param string $dicedNumber
     *
     * @throws InvalidConfigurationException
     * @throws WordlistInvalidException
     *
     * @return string
     */
    public function getWord(string $dicedNumber): string
    {
        $wordlistPath = $this->getWordlistPath();

        if (!File::isReadable($wordlistPath)) {
            throw InvalidConfigurationException::wordlistPath($wordlistPath);
        }

        if ($handle = fopen($wordlistPath, 'r')) {
            while (!feof($handle)) {
                $buffer = fgets($handle);
                if (strpos($buffer, $dicedNumber) !== false) {
                    fclose($handle);

                    return $this->parseWord($buffer);
                }
            }
            fclose($handle);

            throw WordlistInvalidException::wordNotFound($dicedNumber);
        }

        throw InvalidConfigurationException::wordlistPath($wordlistPath);
    }

    /**
     * Get words from the diceware wordlist.
     *
     * @param int $numberOfWords
     *
     * @throws \Exception Thrown if there is not enough entropy.
     *
     * @return array
     */
    public function generateWords(int $numberOfWords): array
    {
        $words = [];
        for ($i = 0; $i < $numberOfWords; $i++) {
            $word = $this->getWord($this->generateDicedNumber());
            if ($this->config['capitalize']) {
                $word = ucfirst($word);
            }
            array_push($words, $word);
        }

        return $words;
    }

    /**
     * Generate a diceware passphrase.
     *
     * @param int|null    $numberOfWords
     * @param string|null $separator
     *
     * @throws \Exception Thrown if there is not enough entropy.
     *
     * @return string
     */
    public function generatePassphrase(?int $numberOfWords = null, ?string $separator = null): string
    {
        $numberOfWords = $numberOfWords ?: $this->config['number_of_words'];
        $separator = $separator ?: $this->config['separator'];

        $words = $this->generateWords($numberOfWords);

        $phrase = implode($separator, $words);

        if ($this->config['add_number']) {
            return random_int(1, 999).$this->config['separator'].$phrase;
        }

        return $phrase;
    }

    /**
     * Set a config variable for this instance.
     *
     * @param string                     $key   Config key
     * @param string|int|float|bool|null $value Value for config key
     */
    public function setConfig(string $key, $value): void
    {
        $this->config[$key] = $value;
    }
}
