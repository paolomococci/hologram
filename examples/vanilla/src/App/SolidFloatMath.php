<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use App\Interfaces\SolidFloatMathInterface;

/**
 * SolidFloatMath
 *
 * Provides basic arithmetic operations (add, subtract, multiply, divide)
 * that operate strictly on floating‑point numbers.
 */
class SolidFloatMath extends SolidAbstractMath implements SolidFloatMathInterface
{
    /**
     * Factory method to create a new instance.
     *
     * @param  string $mode  Optional mode string - kept for future
     *                       extensions.  For now we ignore it and just
     *                       construct a new instance.
     *
     * @return self  A new SolidFloatMath object.
     */
    public static function create(string $mode = 'float'): self
    {
        // If SolidAbstractMath had configuration logic we would forward
        // it here.  For now we simply return a fresh instance.
        return new self();
    }

    /**
     * Add two floating‑point numbers.
     *
     * @param  float $a  The first operand.
     * @param  float $b  The second operand.
     *
     * @return float  The sum of $a and $b.
     */
    public function add(float $a, float $b): float
    {
        return $a + $b;
    }

    /**
     * Subtract one floating‑point number from another.
     *
     * @param  float $a  The minuend.
     * @param  float $b  The subtrahend.
     *
     * @return float  The difference $a - $b.
     */
    public function subtract(float $a, float $b): float
    {
        return $a - $b;
    }

    /**
     * Multiply two floating‑point numbers.
     *
     * @param  float $a  The first factor.
     * @param  float $b  The second factor.
     *
     * @return float  The product $a * $b.
     */
    public function multiply(float $a, float $b): float
    {
        return $a * $b;
    }

    /**
     * Divide one floating‑point number by another.
     *
     * @param  float $a  The dividend.
     * @param  float $b  The divisor.
     *
     * @return float  The quotient $a / $b.
     *
     * @throws \DivisionByZeroError if $b is zero (int or float).
     */
    public function divide(float $a, float $b): float
    {
        // Ensure we don't divide by zero; this throws if $b is 0 or 0.0.
        $this->checkZero($b);

        return $a / $b;
    }
}
