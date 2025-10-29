<?php
namespace Tests\Feature\Models;


use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Modules\Reviews\Models\Review;

use function Pest\Laravel\get;

it('has courses relation', function () {
    //arrange
    $user = User::factory()
    ->has(Course::factory()->count(2),'purchasedCourses')
    ->create();

    //act & assert
    expect($user->purchasedCourses)
    ->toHaveCount(2)
    ->each->toBeInstanceOf(Course::class);
});

it('has videos relation', function () {
    //arrange
    $user = User::factory()
    ->has(Video::factory()->count(2), 'watchedVideos')
    ->create();

    //act & assert
    expect($user->watchedVideos)
    ->toHaveCount(2)
    ->each->toBeInstanceOf(Video::class);
});


it('includes login if not logged in', function () {

    get(route('pages.home'))
    ->assertOk()
    ->assertSeeText('Login')
    ->assertSee(route('login'));

});


it('includes logout if logged in', function () {

    loginAsUser();
    get(route('pages.home'))
    ->assertOk()
    ->assertSeeText('Log out')
    ->assertSee(route('logout'));

});

it('has many reviews', function () {
    //arrange
    $user = User::factory()
    ->has(Review::factory()->count(2), 'reviews')
    ->create();

    //act & assert
    expect($user->reviews)
    ->toHaveCount(2)
    ->each->toBeInstanceOf(Review::class);
});

it('hasReviewedCourse returns true when user has reviewed course', function () {
    //arrange
    $user = User::factory()
    ->has(Review::factory()->count(2), 'reviews')
    ->create();

    //act & assert
    expect($user->hasReviewedCourse($user->reviews->first()->course_id))->toBeTrue();
});

it('hasReviewedCourse returns false when user has not reviewed course', function () {
    //arrange
    $user = User::factory()->create();
    $course = Course::factory()->create();

    //act & assert
    expect($user->hasReviewedCourse($course->id))->toBeFalse();
});



