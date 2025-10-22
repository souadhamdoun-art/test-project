<?php
namespace Tests\Feature\Pages;


use App\Models\Course;
use App\Models\Video;

use function Pest\Laravel\get;


it('does not find unreleased course', function () {
    //arrange
    $course = Course ::factory()->create();

    //act && assert
    get(route('pages.course-details', $course))
    ->assertNotFound();
});

it('shows course details', function () {
    //arrange
    $course = Course ::factory()->released()->create();

    //act && assert
    get(route('pages.course-details', $course))
    ->assertOk()
    ->assertSeeText([
        $course->title,
        $course->description,
        $course->tagline,
        ...$course->learnings,
    ])
    ->assertSee(asset("images/{$course->image_name}"));




});

it('shows course video count', function () {

    $course = Course::factory()->released()
                ->has(Video::factory()->count(3))
                ->create();
    // $video = Video::factory()->count(3)->create([
    //     'course_id' => $course->id,
    // ]); we can replace this by has relation


    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');

});
