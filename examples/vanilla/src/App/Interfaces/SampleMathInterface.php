<?php

declare (strict_types = 1); // Enforce strict type checking

namespace App\Interfaces; // Interface lives in a dedicated namespace

/**
 * Declares the static API that `SampleMath` must implement.
 *
 * All methods are static because the class is stateless
 * and purely functional. Each method specifies the exact
 * argument and return types to enforce a contract.
 */
interface SampleMathInterface
{
    /* --------------------------------------------------------------------- */
    /*  Basic arithmetic - all accept/return floats                          */
    /* --------------------------------------------------------------------- */

    /**
     * add
     *
     * @param  mixed $a
     * @param  mixed $b
     * @return float
     */
    public static function add(float $a, float $b): float;

    /**
     * subtract
     *
     * @param  mixed $a
     * @param  mixed $b
     * @return float
     */
    public static function subtract(float $a, float $b): float;

    /**
     * multiply
     *
     * @param  mixed $a
     * @param  mixed $b
     * @return float
     */
    public static function multiply(float $a, float $b): float;

    /* --------------------------------------------------------------------- */
    /*  Division - may throw DivisionByZeroError                             */
    /* --------------------------------------------------------------------- */

    /**
     * divide
     *
     * @param  mixed $a
     * @param  mixed $b
     * @return float
     */
    public static function divide(float $a, float $b): float;

    /* --------------------------------------------------------------------- */
    /*  Modulus - works with integers only                                   */
    /* --------------------------------------------------------------------- */

    /**
     * module
     *
     * @param  mixed $a
     * @param  mixed $b
     * @return int
     */
    public static function module(int $a, int $b): int;

    /* --------------------------------------------------------------------- */
    /*  Absolute value - returns a float                                     */
    /* --------------------------------------------------------------------- */

    /**
     * absolute
     *
     * @param  mixed $a
     * @return float
     */
    public static function absolute(float $a): float;
}
