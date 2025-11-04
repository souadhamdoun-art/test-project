<?php
namespace Modules\Reviews\tests\Feature;

use App\Models\Course;
use App\Models\User;

it('allows user to create review for purchased course', function () {
    //arrange
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $user->purchasedCourses()->attach($course);

    //act
    $response = $this->actingAs($user)->post(route('reviews.store'), [
        'course_id' => $course->id,
        'rating' => 5,
        'comment' => 'Great course!',
    ]);

    //assert
    $response->assertRedirect(route('pages.home'));
    expect($course->reviews()->count())->toBe(1);
});

