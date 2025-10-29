<?php
namespace Tests\Feature\Models;

use App\Models\Course;
use App\Models\Video;
use Carbon\Carbon;
use Modules\Reviews\Models\Review;

use function Pest\Laravel\get;

// uses(DatabaseMigrations::class);

it('shows courses overview', function () {
    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertSeeText([
            $firstCourse->title,
            $secondCourse->title,
            $thirdCourse->title,
        ]);
});

it('show only released courses', function () {
    // Arrange
    $releasedCourse = Course::factory()->released()->create();
    $notReleasedCourse = Course::factory()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertSeeText([
            $releasedCourse->title,
        ])->assertDontSeeText([
            $notReleasedCourse->title,
        ]);
});

it('shows courses by release date', function () {
    // Arrange
    $firstCourse = Course::factory()->released(Carbon::yesterday())->create();
    $secondCourse = Course::factory()->released(Carbon::now())->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertSeeTextInOrder([
            $secondCourse->title,
            $firstCourse->title,
        ]);
});

it('only returns released courses for released scope', function () {
    // Arrange
    Course::factory()->released()->create();
    Course::factory()->create();

    // Act & Assert
    expect(Course::released()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});

it('has videos relation', function () {
    // Arrange
    $course = Course::factory()->released()->create();
    Video::factory()->count(3)->create([
        'course_id' => $course->id,
    ]);

    // Act & Assert
    expect($course->videos)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Video::class);
});

it('has many reviews', function () {
    //arrange
    $course = Course::factory()
        ->released()
        ->has(Review::factory()->count(3), 'reviews')
        ->create();

    //act & assert
    expect($course->reviews)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Review::class);
});

it('calculates average rating correctly', function () {
    //arrange
    $course = Course::factory()
        ->released()
        ->has(Review::factory()->state(['rating' => 5]), 'reviews')
        ->has(Review::factory()->state(['rating' => 3]), 'reviews')
        ->has(Review::factory()->state(['rating' => 4]), 'reviews')
        ->create();

    //act & assert
    // Average of 5, 3, 4 = 4.0
    expect($course->averageRating)->toBe(4.0);
});

it('averageRating only includes approved reviews', function () {
    //arrange
    $course = Course::factory()
        ->released()
        ->has(Review::factory()->state(['rating' => 5, 'status' => 'approved']), 'reviews')
        ->has(Review::factory()->state(['rating' => 3, 'status' => 'pending']), 'reviews')
        ->has(Review::factory()->state(['rating' => 4, 'status' => 'rejected']), 'reviews')
        ->has(Review::factory()->state(['rating' => 4, 'status' => 'approved']), 'reviews')

        ->create();

    //act & assert
    expect($course->averageRating)->toBe(4.5);
});

it('averageRating returns 0 when no reviews', function () {
    //arrange
    $course = Course::factory()->released()->create();

    //act & assert
    expect($course->averageRating)->toBe(0.0);
});

it('approvedReviews relation returns only approved reviews', function () {
    //arrange
    $course = Course::factory()
        ->released()
        ->has(Review::factory()->state(['rating' => 5, 'status' => 'approved']), 'reviews')
        ->has(Review::factory()->state(['rating' => 3, 'status' => 'pending']), 'reviews')
        ->has(Review::factory()->state(['rating' => 4, 'status' => 'rejected']), 'reviews')
        ->has(Review::factory()->state(['rating' => 4, 'status' => 'approved']), 'reviews')

        ->create();

    //act & assert
    expect($course->approvedReviews)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Review::class);
});

