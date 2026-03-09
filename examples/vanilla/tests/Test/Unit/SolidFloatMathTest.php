<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test\Unit; // Namespace used for unit tests

use App\SolidFloatMath;
use DivisionByZeroError;

// -----------------------------------------------------------------------------
// Helper factory used by every test to create a new SolidFloatMath instance.
// -----------------------------------------------------------------------------
// It simply calls the static create() method on SolidFloatMath.  The
// argument is the mode string; for this test suite we always use 'float'.
function makeFloatMath(): SolidFloatMath
{
    return SolidFloatMath::create('float');
}

// -----------------------------------------------------------------------------
// Test: Adding two positive floats
// -----------------------------------------------------------------------------
// We expect 5.5 + 3.2 to be close to 8.7.  Because of floating-point
// representation we allow a small tolerance (0.01).
it('adds two floats', function () {
    $math   = makeFloatMath();
    $result = $math->add(5.5, 3.2);
    expect(abs($result - 8.7) < 0.01)->toBeTrue();
});

// -----------------------------------------------------------------------------
// Test: Adding a positive and a negative float
// -----------------------------------------------------------------------------
// The sum 10.5 + (-5.2) is 5.3.  We round to one decimal place before
// asserting equality.
it('adds positive and negative floats', function () {
    $math   = makeFloatMath();
    $result = $math->add(10.5, -5.2);
    expect(round($result, 1))->toBe(5.3);
});

// -----------------------------------------------------------------------------
// Test: Subtracting two floats
// -----------------------------------------------------------------------------
// The result of 10.5 - 3.2 should be around 7.30.  We test a narrow range
// to guard against floating-point drift.
it('subtracts two floats', function () {
    $math   = makeFloatMath();
    $result = $math->subtract(10.5, 3.2);
    expect($result)->toBeGreaterThanOrEqual(7.29);
    expect($result)->toBeLessThanOrEqual(7.31);
});

// -----------------------------------------------------------------------------
// Test: Multiplying two floats
// -----------------------------------------------------------------------------
// 5.5 * 3.0 = 16.5.  We allow a tiny tolerance for the same reasons
// as above.
it('multiplies two floats', function () {
    $math   = makeFloatMath();
    $result = $math->multiply(5.5, 3.0);
    expect(abs($result - 16.5) < 0.01)->toBeTrue();
});

// -----------------------------------------------------------------------------
// Test: Dividing two floats
// -----------------------------------------------------------------------------
// 10.0 / 2.0 = 5.0 - again a tolerance check is used.
it('divides two floats', function () {
    $math   = makeFloatMath();
    $result = $math->divide(10.0, 2.0);
    expect(abs($result - 5.0) < 0.01)->toBeTrue();
});

// -----------------------------------------------------------------------------
// Test: Division by zero error! - float zero
// -----------------------------------------------------------------------------
// SolidFloatMath should throw a DivisionByZeroError with the message
// "Division by zero error!" when the divisor is exactly 0.0.
it('throws on division by zero (float zero)', function () {
    $math = makeFloatMath();
    expect(fn() => $math->divide(10.0, 0.0))
        ->toThrow(DivisionByZeroError::class, 'Division by zero error!');
});

// -----------------------------------------------------------------------------
// Test: Division by zero error! - int zero
// -----------------------------------------------------------------------------
// The same exception should be thrown when the divisor is an integer 0.
it('throws on division by zero (int zero)', function () {
    $math = makeFloatMath();
    expect(fn() => $math->divide(10.0, 0))
        ->toThrow(DivisionByZeroError::class, 'Division by zero error!');
});

// -----------------------------------------------------------------------------
// Test: All operations return a float
// -----------------------------------------------------------------------------
// We perform one of each operation and assert that the return type is
// indeed float.  This guards against accidental integer promotion.
it('returns float type for operations', function () {
    $math = makeFloatMath();
    $add  = $math->add(1.1, 2.2);
    $sub  = $math->subtract(5.5, 1);
    $mul  = $math->multiply(2.0, 3.0);
    $div  = $math->divide(9.0, 3.0);

    expect($add)->toBeFloat();
    expect($sub)->toBeFloat();
    expect($mul)->toBeFloat();
    expect($div)->toBeFloat();
});
