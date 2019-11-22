<?php

namespace Martbock\Diceware\Tests\Unit;

use Martbock\Diceware\DicewareServiceProvider;
use Martbock\Diceware\Exceptions\InvalidConfigurationException;
use Martbock\Diceware\Tests\TestCase;

class InvalidConfigurationTest extends TestCase
{
    /** @var DicewareServiceProvider */
    public $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new DicewareServiceProvider(null);
    }

    /** @test
     * @throws InvalidConfigurationException
     */
    public function protect_from_invalid_number_of_words()
    {
        $config = [
            'number_of_words' => 'not an int',
        ];
        $this->expectException(InvalidConfigurationException::class);
        $this->provider->protectFromInvalidConfiguration($config);
    }

    /** @test
     * @throws InvalidConfigurationException
     */
    public function protect_from_invalid_separator()
    {
        $config = [
            'number_of_words' => 1,
            'separator'       => 999,
        ];
        $this->expectException(InvalidConfigurationException::class);
        $this->provider->protectFromInvalidConfiguration($config);
    }

    /** @test
     * @throws InvalidConfigurationException
     */
    public function protect_from_invalid_capitalize()
    {
        $config = [
            'number_of_words' => 1,
            'separator'       => '-',
            'capitalize'      => 'not a boolean',
        ];
        $this->expectException(InvalidConfigurationException::class);
        $this->provider->protectFromInvalidConfiguration($config);
    }

    /** @test
     * @throws InvalidConfigurationException
     */
    public function protect_from_invalid_wordlist_name()
    {
        $config = [
            'number_of_words' => 1,
            'separator'       => '-',
            'capitalize'      => false,
            'wordlist'        => 'not existent wordlist',
        ];
        $this->expectException(InvalidConfigurationException::class);
        $this->provider->protectFromInvalidConfiguration($config);
    }

    /** @test
     * @throws InvalidConfigurationException
     */
    public function protect_from_invalid_custom_wordlist_path()
    {
        $config = [
            'number_of_words'      => 1,
            'separator'            => '-',
            'capitalize'           => false,
            'wordlist'             => 'english',
            'custom_wordlist_path' => '/not/a/file',
        ];
        $this->expectException(InvalidConfigurationException::class);
        $this->provider->protectFromInvalidConfiguration($config);
    }
}
