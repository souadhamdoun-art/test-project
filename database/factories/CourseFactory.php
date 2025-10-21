<?php

namespace Database\Factories;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;



    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(3),
            'tagline' => $this->faker->sentence(3),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->text(100),
            'image_name' => 'image.png',
            'learnings' => ['Learn A ', 'Learn B', 'Learn C'],
        ];
    }

    public function released(?Carbon $date = null): self
    {
        return $this->state(
            fn ($attributes) => [
                'released_at' => $date ?? Carbon::now(),
            ]
        );
    }
}
