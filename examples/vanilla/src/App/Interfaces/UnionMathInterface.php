<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App\Interfaces; // Interface lives in a dedicated namespace

/**
 * UnionMathInterface
 *
 * Declares a simple arithmetic contract that accepts either
 * an integer or a float for both operands and guarantees an
 * `int|float` return value.  Concrete math classes must
 * implement all four operations: add, subtract, multiply, and divide.
 */
interface UnionMathInterface
{
    /**
     * Add two numbers.
     *
     * @param  int|float $a First operand
     * @param  int|float $b Second operand
     * @return int|float Result of the addition
     */
    public function add(int | float $a, int | float $b): int | float;

    /**
     * Subtract the second number from the first.
     *
     * @param  int|float $a Minuend
     * @param  int|float $b Subtrahend
     * @return int|float Result of the subtraction
     */
    public function subtract(int | float $a, int | float $b): int | float;

    /**
     * Multiply two numbers.
     *
     * @param  int|float $a Left factor
     * @param  int|float $b Right factor
     * @return int|float Result of the multiplication
     */
    public function multiply(int | float $a, int | float $b): int | float;

    /**
     * Divide the first number by the second.
     *
     * @param  int|float $a Numerator
     * @param  int|float $b Denominator
     * @return int|float Result of the division
     */
    public function divide(int | float $a, int | float $b): int | float;
}
