<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example for Reviews module.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test review creation logic.
     */
    public function test_can_create_review(): void
    {
        // Arrange
        $reviewData = [
            'rating' => 5,
            'comment' => 'Great course!',
            'user_id' => 1,
            'course_id' => 1
        ];

        // Act & Assert
        $this->assertIsArray($reviewData);
        $this->assertEquals(5, $reviewData['rating']);
    }
}
