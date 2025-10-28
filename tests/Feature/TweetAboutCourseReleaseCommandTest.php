<?php
namespace Tests\Feature;

use App\Console\Commands\TweetAboutCourseReleaseCommand;
use App\Models\Course;
use App\TwitterFacade as Twitter;

it('tweets about release for provided course', function () {

    //arrange
    Twitter::fake();
    $course = Course::factory()->create();
    //act
    $this->artisan(TweetAboutCourseReleaseCommand::class, ['courseId' => $course->id]);
    //assert
    Twitter::assertTweetSent("I just released {$course->title}. Check it out: " . route('pages.course-details', $course));
});
