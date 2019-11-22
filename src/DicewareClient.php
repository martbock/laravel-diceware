<?php

namespace Martbock\Diceware;

class DicewareClient
{
    /** @var WordGenerator */
    protected $wordGenerator;

    /** @var array */
    protected $config;

    public function __construct(WordGenerator $wordGenerator, array $config)
    {
        $this->wordGenerator = $wordGenerator;
        $this->config = $config;
    }

    /**
     * Generate a diceware passphrase.
     * If no parameters are supplied, the default values from
     * the config file are being used.
     *
     * @param int|null    $numberOfWords
     * @param string|null $separator
     *
     * @throws \Exception Thrown if there is not enough entropy.
     *
     * @return string
     */
    public function generate(int $numberOfWords = null, string $separator = null): string
    {
        return $this->wordGenerator->generatePassphrase($numberOfWords, $separator);
    }
}
