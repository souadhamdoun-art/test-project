<?php
namespace Tests\Feature\Pages;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

/**
 * A basic test example.
 */
uses(RefreshDatabase::class);

it('give welcome page', function () {
    get(route('pages.home'))->assertOk();
});


it('give back successful response for course details page', function () {

    $course = Course::factory()->released()->create();
    get(route('pages.course-details', $course))->assertOk();
});


it('give back successful response for dashboard page', function () {
    //arrange
    $user = User::factory()->create();

    //act & assert
    $this->actingAs($user);
    get(route('pages.dashboard'))->assertOk();
});
