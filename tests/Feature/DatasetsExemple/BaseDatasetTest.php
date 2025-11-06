<?php

use App\Models\Course;
use App\Models\User;

describe('Base Dataset Exercise', function () {

    // Datasets simples intégrés directement dans le test
    dataset('simple_course_titles', [
        'laravel_course' => 'Laravel Fundamentals',
        'php_course' => 'Advanced PHP Techniques',
        'vue_course' => 'Vue.js for Beginners'
    ]);

    dataset('simple_ratings', [1, 2, 3, 4, 5]);

    dataset('simple_prices', [0, 29.99, 99.99, 199.99]);

    it('can create courses with different titles', function (string $title) {
        $course = Course::factory()->create([
            'title' => $title,
        ]);
        expect($course)->toBeInstanceOf(Course::class);
        expect($course->title)->toBe($title);
    })->with('simple_course_titles');

    it('can create reviews with different ratings', function (int $rating) {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->purchasedCourses()->attach($course);
        $response = $this->actingAs($user)->post(route('reviews.store'), [
            'course_id' => $course->id,
            'rating' => $rating,
            'comment' => 'Test review',
        ]);
        $review = $course->reviews()->first();
        expect($review->rating)->toBe($rating);

        expect($rating)->toBeLessThanOrEqual(5);
    })->with('simple_ratings');

    it('can create courses with different prices', function (float $price) {
        $course = Course::factory()->create([
            'price' => $price,
        ]);
        expect($course)->toBeInstanceOf(Course::class);
        expect($course->price)->toBe($price);
    })->with('simple_prices');
});
