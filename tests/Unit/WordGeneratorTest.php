<?php

namespace Martbock\Diceware\Tests\Unit;

use Martbock\Diceware\Exceptions\InvalidConfigurationException;
use Martbock\Diceware\Exceptions\WordlistInvalidException;
use Martbock\Diceware\Tests\TestCase;
use Martbock\Diceware\WordGenerator;
use function ucfirst;

class WordGeneratorTest extends TestCase
{
    /** @var array */
    protected $config;

    /** @var WordGenerator */
    protected $wordGenerator;

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

    /** @test
     * @throws \Exception
     */
    public function should_generate_diceware_number()
    {
        $number = $this->wordGenerator->generateDicedNumber();
        $this->assertTrue(is_int((int)$number));
        $this->assertEquals($this->config['number_of_dice'], strlen($number));
    }

    /** @test
     * @throws \Exception
     */
    public function cannot_get_invalid_word()
    {
        $number = '12349';
        $this->expectException(WordlistInvalidException::class);
        $this->wordGenerator->getWord($number);
    }

    /** @test
     * @throws WordlistInvalidException
     */
    public function cannot_parse_invalid_line()
    {
        $this->expectException(WordlistInvalidException::class);
        foreach (['12345', 'invalid line'] as $line) {
            $this->wordGenerator->parseWord($line);
        }
    }

    /** @test
     * @throws WordlistInvalidException
     * @throws InvalidConfigurationException
     */
    public function cannot_open_invalid_wordlist_file()
    {
        $this->wordGenerator->setConfig('custom_wordlist_path', '/invalid/path');
        $this->expectException(InvalidConfigurationException::class);
        $this->wordGenerator->getWord('12345');
    }

    /** @test
     * @throws \Exception
     */
    public function should_capitalize_when_active()
    {
        $this->wordGenerator->setConfig('capitalize', true);
        $words = $this->wordGenerator->generateWords(1);
        foreach ($words as $word) {
            $this->assertEquals(ucfirst($word), $word);
        }
    }

    /** @test
     * @throws \Exception
     */
    public function should_not_capitalize_when_inactive()
    {
        $this->wordGenerator->setConfig('capitalize', false);
        $words = $this->wordGenerator->generateWords(1);
        foreach ($words as $word) {
            $this->assertEquals(strtolower($word), $word);
        }
    }

    /** @test
     * @throws \Exception
     */
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

    /** @test
     * @throws \Exception
     */
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
