<?php

namespace Tests\Feature\Pages;

use App\Models\Course;
use App\Livewire\VideoPlayer;

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
    $course = Course::factory()->create();
    //Act & Assert
    loginAsUser();
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first video by default', function () {

});

it('shows provided course video', function () {

});
