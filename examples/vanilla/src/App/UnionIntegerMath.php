<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use App\Interfaces\UnionMathInterface;  // Interface that declares the required methods.
use App\UnionAbstractMath;              // Abstract base class providing shared logic.

/**
 * UnionIntegerMath
 *
 * Concrete implementation that works with both integers and floats
 * but always **returns an integer**.  It achieves this by casting
 * the result of every operation to `(int)`.  Because of the cast,
 * any fractional part of a float operand is discarded.
 */
class UnionIntegerMath extends UnionAbstractMath implements UnionMathInterface
{
    /**
     * Add two numbers.
     *
     * @param  int|float $a First operand
     * @param  int|float $b Second operand
     * @return int|float Integer result (fractional part truncated)
     */
    public function add(int | float $a, int | float $b): int | float
    {
        return (int) ($a + $b); // Cast to int - fractional part removed.
    }

    /**
     * Subtract $b from $a.
     *
     * @param  int|float $a Minuend
     * @param  int|float $b Subtrahend
     * @return int|float Integer result (fractional part truncated)
     */
    public function subtract(int | float $a, int | float $b): int | float
    {
        return (int) ($a - $b); // Result is cast to int.
    }

    /**
     * Multiply two numbers.
     *
     * @param  int|float $a Left factor
     * @param  int|float $b Right factor
     * @return int|float Integer result (fractional part truncated)
     */
    public function multiply(int | float $a, int | float $b): int | float
    {
        return (int) ($a * $b); // Integer multiplication - cast to int.
    }

    /**
     * Divide $a by $b.
     *
     * @param  int|float $a Numerator
     * @param  int|float $b Denominator
     * @return int|float Integer result (integer division)
     *
     * The method first guards against a zero denominator by calling
     * `$this->checkZero($b)`.  It then performs an **integer division**
     * via PHP’s native `intdiv()` - any remainder is discarded.
     */
    public function divide(int | float $a, int | float $b): int | float
    {
        $this->checkZero($b);              // Guard against division by zero.
        return intdiv((int) $a, (int) $b); // Integer division.
    }
}
