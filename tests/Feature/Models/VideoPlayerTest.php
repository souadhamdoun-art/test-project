<?php
namespace Tests\Feature\Models;

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Livewire\Livewire;


function createCourseAndVideos(int $videosCount = 1): Course
{
    $course = Course::factory()->has(Video::factory()->count($videosCount))->create();
    // Video::factory()->count($videosCount)->create(['course_id' => $course->id]);
    return $course;
}

beforeEach(function () {
    $this->loggedInUser = loginAsUser();
});

it('shows details for given video', function () {
    //arrange
    $course = createCourseAndVideos();
    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
    ->assertSeeText([
        $video->title,
        $video->description,
        $video->duration_in_min . ' minutes',
    ]);
});


it('shows given video', function () {
    //arrange
    $course = createCourseAndVideos();

    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"></iframe>');

        // ->assertSee('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"></iframe>', false);

});

it('shows list of all course videos' , function () {
    //arrange
    $course = createCourseAndVideos(videosCount: 3);
    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
    ->assertSeeText([
       ...$course->videos->pluck('title')->toArray(),
    ])->assertSeeHtml([
        route('pages.course-videos',[$course, $course->videos[1]])
    ]);
});


it('does not include route for current video' , function () {
    //arrange
    $course = createCourseAndVideos();
    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])->assertDontSeeHtml(
        route('pages.course-videos',[$course, $course->videos->first()])
    );
});


it('marks video as completed', function () {
    //arrange
    $user = $this->loggedInUser;
    $course = createCourseAndVideos();

    //assert
    $user->purchasedCourses()->attach($course);
    expect($user->watchedVideos)->toHaveCount(0);
    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
    ->call('markVideoAsCompleted');

    //assert
    $user->refresh();
    expect($user->watchedVideos)->toHaveCount(1)->first()->title->toEqual($video->title);

});

it('marks video as not completed', function () {
    //arrange
    $user =  $this->loggedInUser;
    $course = createCourseAndVideos();

    $user->purchasedCourses()->attach($course);
    $user->watchedVideos()->attach($course->videos->first());

    //assert
    expect($user->watchedVideos)->toHaveCount(1);
    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
    ->call('markVideoAsNotCompleted');

    //assert
    $user->refresh();
    expect($user->watchedVideos)->toHaveCount(0);

});




