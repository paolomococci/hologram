<?php

declare (strict_types = 1); // Enforce strict typing.

namespace App; // Class lives in the App namespace.

use App\Interfaces\IntegerMathInterface;    // Interface that defines integer operations.
use DivisionByZeroError;                    // Exception for division-by-zero.

/**
 * IntegerSampleMath
 *
 * A final class that implements IntegerMathInterface.
 * All operations are static, take integer arguments, and return integers.
 */
final class IntegerSampleMath implements IntegerMathInterface
{
    /**
     * add
     *
     * @param  int $a
     * @param  int $b
     * @return int
     *
     * Adds two integers.
     */
    public static function add(int $a, int $b): int
    {return $a + $b;}

    /**
     * subtract
     *
     * @param  int $a
     * @param  int $b
     * @return int
     *
     * Subtracts $b from $a.
     */
    public static function subtract(int $a, int $b): int
    {return $a - $b;}

    /**
     * multiply
     *
     * @param  int $a
     * @param  int $b
     * @return int
     *
     * Multiplies two integers.
     */
    public static function multiply(int $a, int $b): int
    {return $a * $b;}

    /**
     * divide
     *
     * @param  int $a
     * @param  int $b
     * @return int
     *
     * Performs integer division.  Uses intdiv for PHP 8+.
     * Throws DivisionByZeroError if $b is 0 to avoid runtime errors.
     */
    public static function divide(int $a, int $b): int
    {
        if ($b === 0) {
            throw new DivisionByZeroError("Division by zero error!");
        }

        return intdiv($a, $b); // PHP 7+ helper for integer division
    }
}
