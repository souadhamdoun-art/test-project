<?php

use App\Services\Calculator;

// Pest syntax - much cleaner than PHPUnit!

it('can add two numbers', function () {
    // Arrange
    $calculator = new Calculator;

    // Act
    $result = $calculator->add(2, 3);

    // Assert
    expect($result)->toBe(5);
});

it('can subtract two numbers', function () {
    // Arrange
    $calculator = new Calculator;

    // Act
    $result = $calculator->subtract(5, 3);

    // Assert
    expect($result)->toBe(2);
});

// Even more elegant Pest syntax
test('calculator multiplication', function () {
    $calculator = new Calculator;

    expect($calculator->multiply(3, 4))->toBe(12);
});

// Using describe for grouping tests
describe('Calculator', function () {
    beforeEach(function () {
        $this->calculator = new Calculator;
    });

    it('divides numbers correctly', function () {
        expect($this->calculator->divide(10, 2))->toBe((float) 5);
    });

    it('handles division by zero', function () {
        expect(fn () => $this->calculator->divide(10, 0))
            ->toThrow(InvalidArgumentException::class);
    });
});
