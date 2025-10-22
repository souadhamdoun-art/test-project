<?php
namespace Tests\Feature\Models;


use App\Models\Course;
use App\Models\User;

use function Pest\Laravel\get;

it('has courses relation', function () {
    //arrange
    $user = User::factory()
    ->has(Course::factory()->count(2))
    ->create();

    //act & assert
    expect($user->courses)
    ->toHaveCount(2)
    ->each->toBeInstanceOf(Course::class);
});


it('includes login if not logged in', function () {

    get(route('pages.home'))
    ->assertOk()
    ->assertSeeText('Login')
    ->assertSee(route('login'));

});


it('includes logout if logged in', function () {

    loginAsUser();
    get(route('pages.home'))
    ->assertOk()
    ->assertSeeText('Log out')
    ->assertSee(route('logout'));

});

