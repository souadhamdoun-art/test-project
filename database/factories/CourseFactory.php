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
            'slug' => $this->faker->slug(3) ?: 'default-slug',
            'tagline' => $this->faker->sentence(3),
            'title' => $this->faker->sentence(3) ?: 'Default Course Title',
            'description' => $this->faker->text(100) ?: 'Default course description',
            'image_name' => 'image.png',
            'learnings' => ['Learn A ', 'Learn B', 'Learn C'],
            'paddle_product_id' => $this->faker->uuid(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'is_published' => $this->faker->boolean(75),
            'difficulty' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'discount_percentage' => $this->faker->randomFloat(2, 0, 100),
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
