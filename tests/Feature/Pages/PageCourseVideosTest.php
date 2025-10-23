<?php

namespace Tests\Feature\Pages;

use App\Models\Course;
use App\Livewire\VideoPlayer;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;
use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    //Arrange
    $course = Course::factory()->create();
    //Act & Assert
    get(route('pages.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    //Arrange
    $course = Course::factory()->has(Video::factory())->create();
    //Act & Assert
    loginAsUser();
    get(route('pages.course-videos', [$course,$course->videos->first()]))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first video by default', function () {
    //Arrange
    $course = Course::factory()
    ->has(Video::factory()->state(['title' => 'My Video']))
    ->create();
    //Act & Assert
    loginAsUser();
    get(route('pages.course-videos',[$course,$course->videos->first()]))
        ->assertOk()
        ->assertSeeText('My Video');
});

it('shows provided course video', function () {
    //Arrange
    $course = Course::factory()
    ->has(Video::factory()
        ->state(new Sequence(
            ['title' => 'First video'],
            ['title' => 'Second video']
        ))
        ->count(2)
    )
    ->create();
    //Act & Assert
    loginAsUser();
    get(route('pages.course-videos',[
        'course' =>$course,
        'video'=>$course->videos()->orderByDesc('id')->first()]))
        ->assertOk()
        ->assertSeeText('Second video');
});
