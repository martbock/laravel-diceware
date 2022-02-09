<?php

namespace Martbock\Diceware\Tests\Feature;

use Martbock\Diceware\Facades\Diceware;
use Martbock\Diceware\Tests\TestCase;
use function explode;

class DicewareTest extends TestCase
{
    /** @test */
    public function should_generate_password()
    {
        $password = Diceware::generate();
        $this->assertIsString($password);
        $this->assertTrue(strlen($password) > 0);
    }

    /** @test */
    public function should_contain_correct_amount_of_words()
    {
        $password = Diceware::generate(5, '-');
        $this->assertStringContainsString('-', $password);
        $words = explode('-', $password);
        $this->assertCount(5, $words);
    }
}
