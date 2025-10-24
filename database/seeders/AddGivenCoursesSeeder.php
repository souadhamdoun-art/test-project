<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddGivenCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->isDataAlreadyGiven()) {
            return;
        }
        Course::create([
            'slug' => Str::of('Laravel for Beginners')->slug(),
            'title' => 'Laravel for Beginners',
            'description' => 'Learn Laravel from scratch',
            'image_name' => 'laravel-for-beginners.jpg',
            'learnings' => [
                'How to start with laravel',
                'where to start with laravel',
                'Build your first laravel application',
            ],
            'released_at' => now(),
        ]);

        Course::create([
            'slug' => Str::of('Advanced Laravel')->slug(),
            'title' => 'Advanced Laravel',
            'description' => 'Learn Laravel from scratch',
            'image_name' => 'advanced-laravel.jpg',
            'learnings' => [
                'How to start with laravel',
                'where to start with laravel',
                'Build your first laravel application',
            ],
            'released_at' => now(),
        ]);

        Course::create([
            'slug' => Str::of('TDD the Laravel Way')->slug(),
            'title' => 'TDD the Laravel Way',
            'description' => 'Learn Laravel from scratch',
            'image_name' => 'tdd-the-laravel-way.jpg',
            'learnings' => [
                'How to start with laravel',
                'where to start with laravel',
                'Build your first laravel application',
            ],
            'released_at' => now(),
        ]);
    }

    private function isDataAlreadyGiven(): bool
    {
        return Course::where('title', 'Laravel for Beginners')->exists()
        && Course::where('title', 'Advanced Laravel')->exists()
        && Course::where('title', 'TDD the Laravel Way')->exists();
    }
}
