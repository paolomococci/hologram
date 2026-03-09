<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test; // Namespace used for tests

use App\SampleMath; // Import the class we are going to test.

/**
 * ----------------------------
 *  Individual (non-parameterized)
 * ----------------------------
 */

// Test that the static `add` method correctly adds two floats.
it('adds_two_numbers', function () {
    // `expect(...)->toBe(...)` is Pest’s assertion syntax.
    expect(SampleMath::add(1.5, 2.5))->toBe(4.0);
});

// Test the static `subtract` method.
it('subtracts_two_numbers', function () {
    expect(SampleMath::subtract(5.0, 2.0))->toBe(3.0);
});

// Test the static `multiply` method.
it('multiplies_two_numbers', function () {
    expect(SampleMath::multiply(3.0, 4.0))->toBe(12.0);
});

/**
 * --------------------------------------
 *  Parametric test (data provider inline)
 * --------------------------------------
 *
 * `it()` receives a closure that takes four arguments:
 *   - $method : string name of the static method to call
 *   - $a, $b : operands
 *   - $expected : expected result
 *
 * The `->with([...])` call feeds a list of argument tuples
 * to the closure, turning the single test into a set of
 * three concrete assertions.
 */
it('basic_arithmetic_operations', function ($method, $a, $b, $expected) {
    // Call the static method via variable method name.
    $result = SampleMath::$method($a, $b);
    expect($result)->toBe($expected);
})
    ->with([
        ['add', 1.5, 2.5, 4.0],
        ['subtract', 5.0, 2.0, 3.0],
        ['multiply', 3.0, 4.0, 12.0],
    ]);

/**
 * --------------------------------------
 *  Dataset-based parametric test
 * --------------------------------------
 *
 * `dataset()` creates a named collection of rows that can
 * be reused by any number of tests. Each row is an array
 * that will be unpacked into the test’s parameters.
 *
 * The test itself is identical to the one above, the
 * only difference is that we now fetch the data from the
 * dataset instead of providing it inline.
 */
dataset('basicOperations', [
    ['add', 1.5, 2.7, 4.2],
    ['subtract', 5.5, 2.1, 3.4],
    ['multiply', 3.1, 4.0, 12.4],
]);

it('basic_arithmetic_via_dataset', function ($method, $a, $b, $expected) {
    $result = SampleMath::$method($a, $b);
    expect($result)->toBe($expected);
})
    ->with('basicOperations');
