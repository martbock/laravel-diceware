<?php

namespace Martbock\Diceware\Tests\Unit;

use Martbock\Diceware\Exceptions\InvalidConfigurationException;
use Martbock\Diceware\Exceptions\WordlistInvalidException;
use Martbock\Diceware\Tests\TestCase;
use Martbock\Diceware\WordGenerator;

class WordGeneratorTest extends TestCase
{
    protected ?array $config;
    protected ?WordGenerator $wordGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = [
            'number_of_words'      => 6,
            'separator'            => '-',
            'capitalize'           => false,
            'add_number'           => false,
            'wordlist'             => 'eff',
            'custom_wordlist_path' => null,
            'number_of_dice'       => 5,
        ];
        $this->wordGenerator = new WordGenerator($this->config);
    }

    /** @test */
    public function should_generate_diceware_number()
    {
        $number = $this->wordGenerator->generateDicedNumber();
        $this->assertTrue(is_int((int) $number));
        $this->assertEquals($this->config['number_of_dice'], strlen($number));
    }

    /** @test */
    public function cannot_get_invalid_word()
    {
        $number = '12349';
        $this->expectException(WordlistInvalidException::class);
        $this->wordGenerator->getWord($number);
    }

    /** @test */
    public function cannot_parse_invalid_line()
    {
        $this->expectException(WordlistInvalidException::class);
        foreach (['12345', 'invalid line'] as $line) {
            $this->wordGenerator->parseWord($line);
        }
    }

    /** @test */
    public function cannot_open_invalid_wordlist_file()
    {
        $this->wordGenerator->setConfig('custom_wordlist_path', '/invalid/path');
        $this->expectException(InvalidConfigurationException::class);
        $this->wordGenerator->getWord('12345');
    }

    /** @test */
    public function should_capitalize_when_active()
    {
        $this->wordGenerator->setConfig('capitalize', true);
        $words = $this->wordGenerator->generateWords(3);
        $uppercaseCounter = 0;
        $lowercaseCounter = 0;
        foreach ($words as $word) {
            if (strtoupper($word) === $word) {
                $uppercaseCounter += 1;
            } else {
                $lowercaseCounter += 1;
            }
        }
        $this->assertEquals(1, $uppercaseCounter);
        $this->assertEquals(2, $lowercaseCounter);
    }

    /** @test */
    public function should_not_capitalize_when_inactive()
    {
        $this->wordGenerator->setConfig('capitalize', false);
        $words = $this->wordGenerator->generateWords(2);
        foreach ($words as $word) {
            $this->assertEquals(strtolower($word), $word);
        }
    }

    /** @test */
    public function should_add_number_when_active()
    {
        $this->wordGenerator->setConfig('add_number', true);
        $result = $this->wordGenerator->generatePassphrase();
        $arr = explode($this->config['separator'], $result);
        $this->assertIsNumeric($arr[0]);
        for ($i = 1; $i < $this->config['number_of_words']; $i++) {
            $this->assertIsNotNumeric($arr[$i]);
        }
    }

    /** @test */
    public function should_not_add_number_when_inactive()
    {
        $this->wordGenerator->setConfig('add_number', false);
        $result = $this->wordGenerator->generatePassphrase();
        $arr = explode($this->config['separator'], $result);
        for ($i = 0; $i < $this->config['number_of_words']; $i++) {
            $this->assertIsNotNumeric($arr[$i]);
        }
    }
}
