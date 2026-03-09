<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use App\Interfaces\UnionMathInterface;  // Interface that declares the required methods.
use App\UnionAbstractMath;              // Abstract base class providing shared logic.

/**
 * UnionFloatMath
 *
 * Concrete implementation that works with both integers and floats
 * **and always returns a float**.  It performs the arithmetic
 * operations normally and then casts the result to `(float)`,
 * preserving any fractional component.
 */
class UnionFloatMath extends UnionAbstractMath implements UnionMathInterface
{
    /**
     * Add two numbers.
     *
     * @param  int|float $a First operand
     * @param  int|float $b Second operand
     * @return int|float Float result (fractional part preserved)
     */
    public function add(int | float $a, int | float $b): int | float
    {
        return (float) ($a + $b); // Cast to float - keeps decimals.
    }

    /**
     * Subtract $b from $a.
     *
     * @param  int|float $a Minuend
     * @param  int|float $b Subtrahend
     * @return int|float Float result (fractional part preserved)
     */
    public function subtract(int | float $a, int | float $b): int | float
    {
        return (float) ($a - $b); // Cast to float.
    }

    /**
     * Multiply two numbers.
     *
     * @param  int|float $a Left factor
     * @param  int|float $b Right factor
     * @return int|float Float result (fractional part preserved)
     */
    public function multiply(int | float $a, int | float $b): int | float
    {
        return (float) ($a * $b); // Cast to float.
    }

    /**
     * Divide $a by $b.
     *
     * @param  int|float $a Numerator
     * @param  int|float $b Denominator
     * @return int|float Float result (fractional part preserved)
     *
     * As with `UnionIntegerMath`, the method first ensures the
     * denominator isn’t zero.  It then performs the division
     * using PHP’s normal `/` operator and casts the result to
     * `(float)`, guaranteeing a floating-point return value.
     */
    public function divide(int | float $a, int | float $b): int | float
    {
        $this->checkZero($b);     // Guard against division by zero.
        return (float) ($a / $b); // Perform float division.
    }
}
