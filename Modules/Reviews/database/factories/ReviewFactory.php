<?php

namespace Modules\Reviews\database\factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Reviews\Models\Review;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence(),
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'status' => 'pending', // Par défaut pending
        ];
    }

    /**
     * Create an approved review
     */
    public function approved(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Create a rejected review
     */
    public function rejected(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }

    /**
     * Create a pending review (explicit method)
     */
    public function pending(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }
}

