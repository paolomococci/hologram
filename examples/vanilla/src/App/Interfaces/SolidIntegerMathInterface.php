<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App\Interfaces; // Interface lives in a dedicated namespace

/**
 * SolidIntegerMathInterface
 *
 * Contract that defines the basic arithmetic operations for integer
 * mathematics.  Implementations must return integers for all methods.
 */
interface SolidIntegerMathInterface
{
    /**
     * Add two integers.
     *
     * @param  int $a
     * @param  int $b
     * @return int
     */
    public function add(int $a, int $b): int;

    /**
     * Subtract the second integer from the first.
     *
     * @param  int $a
     * @param  int $b
     * @return int
     */
    public function subtract(int $a, int $b): int;

    /**
     * Multiply two integers.
     *
     * @param  int $a
     * @param  int $b
     * @return int
     */
    public function multiply(int $a, int $b): int;

    /**
     * Divide the first integer by the second using integer division.
     *
     * @param  int $a
     * @param  int $b
     * @return int
     *
     * @throws \DivisionByZeroError if $b is zero
     */
    public function divide(int $a, int $b): int;
}
