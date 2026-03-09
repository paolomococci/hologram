<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use App\Interfaces\FloatMathInterface; // Interface defining the contract for float math.
use DivisionByZeroError;

// Built-in exception for division-by-zero.

/**
 * FloatSampleMath
 *
 * A final class that implements FloatMathInterface.
 * All operations are static and accept float parameters,
 * returning float results.  No state is stored in the object.
 */
final class FloatSampleMath implements FloatMathInterface
{
    /**
     * add
     *
     * @param  float $a
     * @param  float $b
     * @return float
     *
     * Adds two floats and returns the result.
     */
    public static function add(float $a, float $b): float
    {return $a + $b;}

    /**
     * subtract
     *
     * @param  float $a
     * @param  float $b
     * @return float
     *
     * Subtracts the second float from the first.
     */
    public static function subtract(float $a, float $b): float
    {return $a - $b;}

    /**
     * multiply
     *
     * @param  float $a
     * @param  float $b
     * @return float
     *
     * Multiplies two floats.
     */
    public static function multiply(float $a, float $b): float
    {return $a * $b;}

    /**
     * divide
     *
     * @param  float $a
     * @param  float $b
     * @return float
     *
     * Divides $a by $b.  Throws DivisionByZeroError if $b is 0.0
     * to guard against an invalid operation.
     */
    public static function divide(float $a, float $b): float
    {
        // Typical tolerance for engineering applications.
        // $epsilonEngineering = 1e-8;
        // Typical tolerance for financial applications.
        // $epsilonFinancial = 1e-9;
        // Typical tolerance for scientific applications.
        $epsilonScientific = 1e-12;
        // Relative tolerance.
        $epsilonRelative = $epsilonScientific * max(1.0, abs($b));
        if (abs($b) < $epsilonRelative) {
            throw new DivisionByZeroError("Division by zero error!");
        }

        return $a / $b;
    }
}
