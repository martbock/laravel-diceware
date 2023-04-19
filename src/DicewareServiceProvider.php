<?php

namespace Martbock\Diceware;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Martbock\Diceware\Exceptions\InvalidConfigurationException;

use function is_bool;
use function is_int;
use function is_string;

class DicewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/diceware.php' => config_path('diceware.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/diceware.php', 'diceware');

        $this->app->bind(WordGenerator::class, function () {
            $dicewareConfig = config('diceware');

            return new WordGenerator($dicewareConfig);
        });

        $this->app->bind(DicewareClient::class, function () {
            $dicewareConfig = config('diceware');

            $this->protectFromInvalidConfiguration($dicewareConfig);

            $generator = app(WordGenerator::class);

            return new DicewareClient($generator, $dicewareConfig);
        });

        $this->app->alias(DicewareClient::class, 'laravel-diceware');
    }

    /**
     * Throw an exception on configuration errors.
     *
     * @param array $config
     *
     * @throws InvalidConfigurationException
     */
    public function protectFromInvalidConfiguration(array $config)
    {
        if (!is_int($config['number_of_words'])) {
            throw InvalidConfigurationException::numberOfWords();
        }
        if (!is_string($config['separator'])) {
            throw InvalidConfigurationException::separator();
        }
        if (!is_bool($config['capitalize'])) {
            throw InvalidConfigurationException::capitalize();
        }
        if ($config['wordlist'] !== 'english' && $config['wordlist'] !== 'eff' && $config['wordlist'] !== 'german') {
            throw InvalidConfigurationException::wordlist();
        }
        if ($config['custom_wordlist_path'] != null && !File::isReadable($config['custom_wordlist_path'])) {
            throw InvalidConfigurationException::wordlistPath($config['custom_wordlist_path']);
        }
    }
}
