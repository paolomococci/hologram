<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test\Unit; // Namespace used for unit tests

use App\Interfaces\SolidFloatMathInterface;
use App\Interfaces\SolidIntegerMathInterface;
use App\SolidFloatMath;
use App\SolidIntegerMath;
use App\SolidMathFactory;
use InvalidArgumentException;

describe('SolidMathFactory', function () {

    it('should create integer math instance', function () {
        $math = SolidMathFactory::create('int');
        expect($math)->toBeInstanceOf(SolidIntegerMathInterface::class);
        expect($math)->toBeInstanceOf(SolidIntegerMath::class);
    });

    it('should create float math instance', function () {
        $math = SolidMathFactory::create('float');
        expect($math)->toBeInstanceOf(SolidFloatMathInterface::class);
        expect($math)->toBeInstanceOf(SolidFloatMath::class);
    });

    it('should throw exception for unknown type', function () {
        expect(fn() => SolidMathFactory::create('decimal'))
            ->toThrow(InvalidArgumentException::class);
    });

    it('should return singleton instances', function () {
        $math1 = SolidMathFactory::create('int');
        $math2 = SolidMathFactory::create('int');

        expect($math1)->toBe($math2);
    });

    it('should return different instances for different types', function () {
        $intMath   = SolidMathFactory::create('int');
        $floatMath = SolidMathFactory::create('float');

        expect($intMath)->not()->toBe($floatMath);
    });

});
