<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddGivenVideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->isDataAlreadyGiven()) {
            return;
        }

        $laravelForBeginners = Course::where('title', 'Laravel for Beginners')->firstOrFail();
        $advancedLaravel = Course::where('title', 'Advanced Laravel')->firstOrFail();
        $tddTheLaravelWay = Course::where('title', 'TDD the Laravel Way')->firstOrFail();

        Video::insert([
            [
                'course_id' => $laravelForBeginners->id,
                'slug' => 'intro',
                'vimeo_id' => '330287829',
                'title' => 'Intro',
                'description' => 'welcome to the course',
                'duration_in_min' => 1,
            ],
            [
                'course_id' => $advancedLaravel->id,
                'slug' => 'advanced-laravel-intro',
                'vimeo_id' => '330287829',
                'title' => 'Advanced Laravel',
                'description' => 'welcome to the course',
                'duration_in_min' => 4,
            ],
            [
                'course_id' => $tddTheLaravelWay->id,
                'slug' => 'slug-tdd-the-laravel-way-intro',
                'vimeo_id' => '330287829',
                'title' => 'TDD the Laravel Way',
                'description' => 'welcome to the course',
                'duration_in_min' => 8,
            ],
             [
                'course_id' => $laravelForBeginners->id,
                'slug' => 'slug-laravel-for-beginners-intro',
                'vimeo_id' => '330287829',
                'title' => 'Intro',
                'description' => 'welcome to the course',
                'duration_in_min' => 1,
            ],
            [
                'course_id' => $advancedLaravel->id,
                'slug' => 'slug-laravel-intro',
                'vimeo_id' => '330287829',
                'title' => 'Advanced Laravel',
                'description' => 'welcome to the course',
                'duration_in_min' => 4,
            ],
            [
                'course_id' => $tddTheLaravelWay->id,
                'slug' => 'slug-tdd',
                'vimeo_id' => '330287829',
                'title' => 'TDD the Laravel Way',
                'description' => 'welcome to the course',
                'duration_in_min' => 8,
            ],
             [
                'course_id' => $laravelForBeginners->id,
                'slug' => 'slug-beginners-intro',
                'vimeo_id' => '330287829',
                'title' => 'Intro',
                'description' => 'welcome to the course',
                'duration_in_min' => 1,
            ],
            [
                'course_id' => $advancedLaravel->id,
                'slug' => 'slug-advanced-intro',
                'vimeo_id' => '330287829',
                'title' => 'Advanced Laravel',
                'description' => 'welcome to the course',
                'duration_in_min' => 4,
            ],


        ]);
    }

    private function isDataAlreadyGiven(): bool
    {
        $laravelForBeginners = Course::where('title', 'Laravel for Beginners')->firstOrFail();
        $advancedLaravel = Course::where('title', 'Advanced Laravel')->firstOrFail();
        $tddTheLaravelWay = Course::where('title', 'TDD the Laravel Way')->firstOrFail();

        return Video::where('course_id', $laravelForBeginners->id)->count() == 3
        && Video::where('course_id', $advancedLaravel->id)->count() == 3
        && Video::where('course_id', $tddTheLaravelWay->id)->count() == 2;
    }
}
