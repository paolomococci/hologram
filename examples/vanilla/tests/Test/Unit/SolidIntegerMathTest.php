<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test\Unit; // Namespace used for unit tests

use App\SolidIntegerMath;
use DivisionByZeroError;

// Pest description block, groups all tests for SolidIntegerMath.
describe('SolidIntegerMath', function () {

    // Helper factory that creates a SolidIntegerMath instance with the
    // default mode.  The mode argument is kept for symmetry with other
    // providers that might support different numeric modes.
    function makeIntegerMath(): SolidIntegerMath
    {
        return SolidIntegerMath::create('int');
    }

    /** ------------------------------------------------------------------
     *  Add method tests
     * ------------------------------------------------------------------ */
    describe('add', function () {
        it('should add two positive integers', function () {
            $math = makeIntegerMath();
            expect($math->add(5, 3))->toBe(8);
        });

        it('should add positive and negative integers', function () {
            $math = makeIntegerMath();
            expect($math->add(10, -5))->toBe(5);
        });

        it('should add two negative integers', function () {
            $math = makeIntegerMath();
            expect($math->add(-5, -3))->toBe(-8);
        });

        it('should add zero', function () {
            $math = makeIntegerMath();
            expect($math->add(0, 5))->toBe(5);
            expect($math->add(5, 0))->toBe(5);
        });
    });

    /** ------------------------------------------------------------------
     *  Subtract method tests
     * ------------------------------------------------------------------ */
    describe('subtract', function () {
        it('should subtract two positive integers', function () {
            $math = makeIntegerMath();
            expect($math->subtract(10, 3))->toBe(7);
        });

        it('should subtract and get negative result', function () {
            $math = makeIntegerMath();
            expect($math->subtract(3, 10))->toBe(-7);
        });

        it('should subtract negative from positive', function () {
            $math = makeIntegerMath();
            expect($math->subtract(10, -5))->toBe(15);
        });

        it('should subtract equal numbers', function () {
            $math = makeIntegerMath();
            expect($math->subtract(5, 5))->toBe(0);
        });
    });

    /** ------------------------------------------------------------------
     *  Multiply method tests
     * ------------------------------------------------------------------ */
    describe('multiply', function () {
        it('should multiply two positive integers', function () {
            $math = makeIntegerMath();
            expect($math->multiply(5, 3))->toBe(15);
        });

        it('should multiply positive by negative', function () {
            $math = makeIntegerMath();
            expect($math->multiply(5, -3))->toBe(-15);
        });

        it('should multiply two negative integers', function () {
            $math = makeIntegerMath();
            expect($math->multiply(-5, -3))->toBe(15);
        });

        it('should multiply by zero', function () {
            $math = makeIntegerMath();
            expect($math->multiply(5, 0))->toBe(0);
        });

        it('should multiply by one', function () {
            $math = makeIntegerMath();
            expect($math->multiply(5, 1))->toBe(5);
        });
    });

    /** ------------------------------------------------------------------
     *  Divide method tests
     * ------------------------------------------------------------------ */
    describe('divide', function () {
        it('should divide two positive integers', function () {
            $math = makeIntegerMath();
            expect($math->divide(10, 3))->toBe(3); // integer division
        });

        it('should divide with exact result', function () {
            $math = makeIntegerMath();
            expect($math->divide(10, 2))->toBe(5);
        });

        it('should divide positive by negative', function () {
            $math = makeIntegerMath();
            expect($math->divide(10, -2))->toBe(-5);
        });

        it('should divide two negative integers', function () {
            $math = makeIntegerMath();
            expect($math->divide(-10, -2))->toBe(5);
        });

        it('should throw exception on division by zero', function () {
            $math = makeIntegerMath();
            expect(fn() => $math->divide(10, 0))
                ->toThrow(DivisionByZeroError::class, 'Division by zero error!');
        });

        it('should return integer type', function () {
            $math   = makeIntegerMath();
            $result = $math->divide(10, 3);
            expect($result)->toBeInt(); // ensures return is an int
        });
    });

});
