<?php
namespace Tests\Feature\Pages;

use App\Models\Course;
use App\Models\Video;
use App\Models\User;

use function Pest\Laravel\get;

/**
 * A basic test example.
 */

it('give welcome page', function () {
    get(route('pages.home'))->assertOk();
});


it('give back successful response for course details page', function () {

    $course = Course::factory()->released()->create();
    get(route('pages.course-details', $course))->assertOk();
});


it('give back successful response for dashboard page', function () {
    loginAsUser();
    get(route('pages.dashboard'))->assertOk();
});

it('does not find jetStream registration page', function () {
    get('register')->assertNotFound();
});

it('gives successful response for videos page', function () {
    //arrange
    $course = Course::factory()
    ->has(Video::factory())
    ->create();
    // act & assert
    loginAsUser();
    get(route('pages.course-videos', $course))
    ->assertOk();
});



