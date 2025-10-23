<?php
namespace Tests\Feature\Models;

use App\Models\Course;
use App\Models\Video;

it('gives back readable video duration', function () {
    //arrange
    $video = Video::factory()->create([
        'duration_in_min' => 10,
    ]);
    //act & assert
    expect($video->getReadableDuration())->toBe('10 minutes');
});


it('belongs to a course', function () {
    //arrange
    $video = Video::factory()
            ->has(Course::factory())
            ->create();

    //act & assert
    expect($video->course)
    ->toBeInstanceOf(Course::class);
});
