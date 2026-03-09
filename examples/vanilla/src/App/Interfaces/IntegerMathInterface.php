<?php

declare (strict_types = 1); // Enforce strict typing.

namespace App\Interfaces; // Placed under the App\Interfaces namespace.

/**
 * IntegerMathInterface
 *
 * Similar to FloatMathInterface but operates on integers.
 * Every static method accepts integer arguments and returns an integer.
 */
interface IntegerMathInterface
{
    /**
     * add
     *
     * @param  int $a
     * @param  int $b
     * @return int
     */
    public static function add(int $a, int $b): int;

    /**
     * subtract
     *
     * @param  int $a
     * @param  int $b
     * @return int
     */
    public static function subtract(int $a, int $b): int;

    /**
     * multiply
     *
     * @param  int $a
     * @param  int $b
     * @return int
     */
    public static function multiply(int $a, int $b): int;

    /**
     * divide
     *
     * @param  int $a
     * @param  int $b
     * @return int
     */
    public static function divide(int $a, int $b): int;
}
