<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test; // Namespace used for tests

use App\MathFactory; // Import the MathFactory class so we can obtain a float calculator instance.

/**
 * Define a data-driven dataset for the test.
 *
 * Every element of the array is a single test case described by
 *   [$method, $a, $b, $expected]
 *
 * The four rows test the four arithmetic operations.
 */
dataset('floatOperations', [
    ['add', 1.5, 2.3, 3.8],
    ['subtract', 4.2, 1.1, 3.1],
    ['multiply', 2.5, 4.0, 10.0],
    ['divide', 9.0, 3.0, 3.0],
]);

/**
 * “float math” test case.
 *
 * For every row in the dataset we:
 *   1. Grab a float-math calculator via MathFactory::float().
 *   2. Call the requested static method (add, subtract, etc.) on the
 *      calculator’s class using call_user_func.
 *   3. Assert that the returned value equals the expected result.
 *
 * The test is automatically repeated for all rows using the
 *   ->with('floatOperations') helper from Pest.
 */
it('float math', function (string $method, float $a, float $b, float $expected) {
    // Retrieve a concrete float math implementation.
    $calculator = MathFactory::float();

    // Dynamically invoke the static method (e.g. FloatSampleMath::add).
    // $calculator::class gives us the fully-qualified class name.
    expect(call_user_func([$calculator::class, $method], $a, $b))
        ->toBe($expected); // Assert the result matches $expected.
})->with('floatOperations');
