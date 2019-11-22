<?php


namespace Martbock\Diceware\Tests;


use Martbock\Diceware\DicewareServiceProvider;
use Martbock\Diceware\Facades\Diceware;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function getPackageProviders($app)
    {
        return [DicewareServiceProvider::class];
    }

    public function getPackageAliases($app)
    {
        return [
            'Diceware' => Diceware::class,
        ];
    }
}