<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use App\Interfaces\SolidIntegerMathInterface;

/**
 * SolidIntegerMath
 *
 * Concrete implementation of integer mathematics that satisfies the
 * SolidIntegerMathInterface contract.  It extends SolidAbstractMath
 * to reuse common logic such as zero-division checks.
 */
class SolidIntegerMath extends SolidAbstractMath implements SolidIntegerMathInterface
{
    /**
     * Factory method.
     *
     * @param  string $mode  (unused for integers but kept for API parity)
     * @return self
     */
    public static function create(string $mode = 'int'): self
    {
        // If the abstract class had configuration logic, it would be forwarded here.
        return new self();
    }

    /**
     * Add two integers.
     *
     * @param  int $a
     * @param  int $b
     * @return int  The sum
     */
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    /**
     * Subtract the second integer from the first.
     *
     * @param  int $a
     * @param  int $b
     * @return int  The difference
     */
    public function subtract(int $a, int $b): int
    {
        return $a - $b;
    }

    /**
     * Multiply two integers.
     *
     * @param  int $a
     * @param  int $b
     * @return int  The product
     */
    public function multiply(int $a, int $b): int
    {
        return $a * $b;
    }

    /**
     * Divide the first integer by the second using integer division.
     *
     * @param  int $a
     * @param  int $b
     * @return int  The quotient (truncated towards zero)
     *
     * @throws \DivisionByZeroError if $b is zero
     */
    public function divide(int $a, int $b): int
    {
        $this->checkZero($b);  // guard against division by zero
        return intdiv($a, $b); // PHP 7+ built-in integer division
    }
}
