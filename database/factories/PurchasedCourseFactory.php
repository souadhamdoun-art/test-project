<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\PurchasedCourse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchasedCourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchasedCourse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'status' => 'pending',
        ];
    }
}
