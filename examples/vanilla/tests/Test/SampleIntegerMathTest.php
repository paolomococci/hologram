<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test; // Namespace used for tests

use App\MathFactory; // Import the MathFactory class so we can call its static methods.

// Define a data-set for parameterized testing.
// Each inner array contains: [method name, operand a, operand b, expected result].
dataset('integerOperations', [
    ['add', 10, 5, 15],
    ['subtract', 20, 3, 17],
    ['multiply', 7, 8, 56],
    ['divide', 20, 5, 4], // Uses intdiv (integer division) in the implementation.
]);

/**
 * “integer math” test case.
 *
 * For each tuple in the dataset we:
 *  1. Create an integer calculator instance via MathFactory.
 *  2. Dynamically call the requested static method on the calculator’s class
 *     using call_user_func ([$calculator::class, $method]).
 *  3. Assert that the returned value matches the expected integer.
 *
 * The test is automatically repeated for each row of data using the
 * ->with('integerOperations') syntax provided by Pest.
 */
it('integer math', function (string $method, int $a, int $b, int $expected) {
    // Obtain a calculator that implements IntegerMathInterface.
    $calculator = MathFactory::integer();

    // Dynamically call the static method (add/subtract/multiply/divide) on the calculator's class.
    expect(call_user_func([$calculator::class, $method], $a, $b))
        ->toBe($expected); // Expect the result to equal $expected.
})->with('integerOperations');
