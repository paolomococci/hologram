<?php
namespace App;

use Helpers\IconHelper;

/**
 * Lithos
 */
class Lithos
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * __invoke
     *
     * @param  mixed $name
     * @param  mixed $class
     * @param  mixed $ariaLabel
     * @param  mixed $title
     * @return string
     */
    public function __invoke(string $name, string $class = 'w-6 h-6', ?string $ariaLabel = null, ?string $title = null): string
    {
        return IconHelper::inlineIcon($name, $class, $ariaLabel, $title);
    }
}
