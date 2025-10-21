<?php

// Simple Pest-style test runner for TDD practice
require_once 'vendor/autoload.php';

use App\Services\Calculator;

echo "🧪 Running Pest-style TDD Tests...\n\n";

// Test helper functions (mimicking Pest)
function it(string $description, callable $test): void
{
    echo "✓ it $description\n";
    try {
        $test();
        echo "  ✅ PASS\n";
    } catch (Exception $e) {
        echo '  ❌ FAIL: '.$e->getMessage()."\n";
    }
    echo "\n";
}

function expectValue($value)
{
    return new class($value)
    {
        private $value;

        public function __construct($value)
        {
            $this->value = $value;
        }

        public function toBe($expected)
        {
            if ($this->value !== $expected) {
                throw new Exception("Expected $expected, got {$this->value}");
            }

            return $this;
        }

        public function toThrow(string $exceptionClass)
        {
            try {
                if (is_callable($this->value)) {
                    ($this->value)();
                }
                throw new Exception("Expected $exceptionClass to be thrown, but no exception was thrown");
            } catch (Exception $e) {
                if (! $e instanceof $exceptionClass) {
                    throw new Exception("Expected $exceptionClass, got ".get_class($e));
                }
            }

            return $this;
        }
    };
}

// Run the tests
echo "🔢 Calculator Tests\n";
echo "==================\n\n";

it('can add two numbers', function () {
    $calculator = new Calculator;
    $result = $calculator->add(2, 3);
    expectValue($result)->toBe(5);
});

it('can subtract two numbers', function () {
    $calculator = new Calculator;
    $result = $calculator->subtract(5, 3);
    expectValue($result)->toBe(2);
});

it('can multiply two numbers', function () {
    $calculator = new Calculator;
    $result = $calculator->multiply(3, 4);
    expectValue($result)->toBe(12);
});

it('can divide two numbers', function () {
    $calculator = new Calculator;
    $result = $calculator->divide(10, 2);
    expectValue($result)->toBe(5.0);
});

it('throws exception on division by zero', function () {
    $calculator = new Calculator;
    expectValue(fn () => $calculator->divide(10, 0))->toThrow(InvalidArgumentException::class);
});

echo "🎉 All tests completed!\n";
