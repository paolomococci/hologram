<?php

declare (strict_types = 1); // Enforce strict type checking

namespace App; // The class lives in the App namespace.

use App\Interfaces\SampleMathInterface; // Interface that declares the public contract
use DivisionByZeroError;                // Built-in error thrown when dividing by zero

/**
 * Final class - cannot be extended.
 *
 * Implements `SampleMathInterface`, which guarantees the
 * presence of a fixed set of static methods. All methods
 * are static because the class is purely functional.
 */
final class SampleMath implements SampleMathInterface
{
    /* --------------------------------------------------------------------- */
    /*  Arithmetic operations - all accept/return floats                     */
    /* --------------------------------------------------------------------- */

    /**
     * Add two numbers.
     *
     * @param float $a First operand
     * @param float $b Second operand
     * @return float Sum of $a and $b
     */
    public static function add(float $a, float $b): float
    {
        return $a + $b;
    }

    /**
     * Subtract $b from $a.
     *
     * @param float $a Minuend
     * @param float $b Subtrahend
     * @return float Difference
     */
    public static function subtract(float $a, float $b): float
    {
        return $a - $b;
    }

    /**
     * Multiply two numbers.
     *
     * @param float $a First factor
     * @param float $b Second factor
     * @return float Product
     */
    public static function multiply(float $a, float $b): float
    {
        return $a * $b;
    }

    /* --------------------------------------------------------------------- */
    /*  Division - includes error handling                                 */
    /* --------------------------------------------------------------------- */

    /**
     * Divide $a by $b.
     *
     * @param float $a Dividend
     * @param float $b Divisor
     * @return float Quotient
     *
     * @throws DivisionByZeroError When $b is zero.
     */
    public static function divide(float $a, float $b): float
    {
        // Typical tolerance for scientific applications.
        $epsilonScientific = 1e-12;
        // Relative tolerance.
        $epsilonRelative = $epsilonScientific * max(1.0, abs($b));
        if (abs($b) < $epsilonRelative) {
            // Throw a built-in error so the caller can catch it if desired.
            throw new DivisionByZeroError("Division by zero error!");
        }

        return $a / $b;
    }

    /* --------------------------------------------------------------------- */
    /*  Integer specific operations - only accept ints                     */
    /* --------------------------------------------------------------------- */

    /**
     * Return the modulus (remainder) of $a divided by $b.
     *
     * @param int $a Dividend
     * @param int $b Divisor
     * @return int Remainder
     */
    public static function module(int $a, int $b): int
    {
        return $a % $b;
    }

    /* --------------------------------------------------------------------- */
    /*  Utility - absolute value                                           */
    /* --------------------------------------------------------------------- */

    /**
     * Return the absolute value of a float.
     *
     * @param float $a Value
     * @return float |int Absolute value
     */
    public static function absolute(float $a): float
    {
        return abs($a);
    }
}
