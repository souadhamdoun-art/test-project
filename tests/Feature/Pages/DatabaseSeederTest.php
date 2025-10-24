<?php
namespace Tests\Feature\Pages;

use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\App;

it('adds given courses', function () {

    //arrange
    $this->assertDatabaseCount(Course::class, 0);

    //act

    $this->artisan('db:seed');

    //assert
    $this->assertDatabaseCount(Course::class, 3);
    $this->assertDatabaseHas(Course::class, ['title' => 'Laravel for Beginners']);
    $this->assertDatabaseHas(Course::class, ['title' => 'Advanced Laravel']);
    $this->assertDatabaseHas(Course::class, ['title' => 'TDD the Laravel Way']);

});

it('adds given courses only once', function () {

    //act
    $this->artisan('db:seed');
    $this->artisan('db:seed');
    //assert
    $this->assertDatabaseCount(Course::class, 3);

});

it('adds given videos', function () {

    //arrange
    $this->assertDatabaseCount(Video::class, 0);

    //act

    $this->artisan('db:seed');

    //assert
    $laravelForBeginners = Course::where('title', 'Laravel for Beginners')->firstOrFail();
    $advancedLaravel = Course::where('title', 'Advanced Laravel')->firstOrFail();
    $tddTheLaravelWay = Course::where('title', 'TDD the Laravel Way')->firstOrFail();

    $this->assertDatabaseCount(Video::class, 8);

    expect($laravelForBeginners)
        ->videos
        ->toHaveCount(3);
    expect($advancedLaravel)
        ->videos
        ->toHaveCount(3);
    expect($tddTheLaravelWay)
        ->videos
        ->toHaveCount(2);

});

it('adds local test user', function () {

    //arrange
    App::partialMock()->shouldReceive('environment')->andReturn('local');

    //assert
    $this->assertDatabaseCount(User::class, 0);

    //act

    $this->artisan('db:seed');

    //assert
    $this->assertDatabaseCount(User::class, 1);
    $this->assertDatabaseHas(User::class, ['email' => 'test@example.com']);

});

it('does not add test user for production', function () {

    //arrange
    App::partialMock()->shouldReceive('environment')->andReturn('production');

    //assert
    $this->assertDatabaseCount(User::class, 0);

    //act

    $this->artisan('db:seed');

    //assert
    $this->assertDatabaseCount(User::class, 0);

});
