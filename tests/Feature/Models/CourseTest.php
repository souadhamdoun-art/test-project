<?php
namespace Tests\Feature\Models;

use App\Models\Course;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

// uses(DatabaseMigrations::class);
uses(RefreshDatabase::class);

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
