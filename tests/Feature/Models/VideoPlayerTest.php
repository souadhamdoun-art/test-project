<?php
namespace Tests\Feature\Models;

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;


it('shows details for given video', function () {
    //arrange
    $course = Course::factory()
    ->has(Video::factory())->create();

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
    $course = Course::factory()
    ->has(Video::factory())->create();

    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"></iframe>');

        // ->assertSee('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"></iframe>', false);

});

it('shows list of all course videos' , function () {
    //arrange
    $course = Course::factory()
    ->has(Video::factory()
    ->count(3)
    ->state(new Sequence(
        ['title' => 'First video'],
        ['title' => 'Second video'],
        ['title' => 'Third video']
    ))
    )->create();

    //act & assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
    ->assertSeeText([
        $course->videos->first()->title,
        $course->videos->last()->title,
    ])->assertSeeHtml([
        route('pages.course-videos',Video::where('title','First video')->first())
    ]);
});


it('marks video as completed', function () {
    //arrange
    $user = User::factory()->create();
    $course = Course::factory()
    ->has(Video::factory()->state(['title' => 'Course video']))
    ->create();

    //assert
    $user->courses()->attach($course);
    expect($user->videos)->toHaveCount(0);
    //act & assert
    loginAsUser($user);
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
    ->call('markVideoAsCompleted');

    //assert
    $user->refresh();
    expect($user->videos)->toHaveCount(1)->first()->title->toEqual('Course video');

});

it('marks video as not completed', function () {
    //arrange
    $user = User::factory()->create();
    $course = Course::factory()
    ->has(Video::factory()->state(['title' => 'Course video']))
    ->create();

    $user->courses()->attach($course);
    $user->videos()->attach($course->videos->first());

    //assert
    expect($user->videos)->toHaveCount(1);
    //act & assert
    loginAsUser($user);
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
    ->call('markVideoAsNotCompleted');

    //assert
    $user->refresh();
    expect($user->videos)->toHaveCount(0);

});




