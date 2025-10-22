<?php
namespace Tests\Feature\Pages;

use function Pest\Laravel\get;

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;


it('cannot be accessed by guest', function () {
    get(route('pages.dashboard'))->assertRedirect(route('login'));
});


it('list purchased courses', function () {
    //arrange
    $user = User::factory()
    ->has(Course::factory()->count(2)->state(
       new Sequence(
                    ['title' => 'Course A'],
                    ['title' => 'Course B']
                )
        ))
        ->create();
    //act & assert
    loginAsUser($user);
    get(route('pages.dashboard'))
    ->assertOk()
    ->assertSeeText(['Course A', 'Course B']);
});

it('does not list other courses', function () {
    //arrange
    $course = Course::factory()->create();

    //act & assert
    loginAsUser();
    get(route('pages.dashboard'))
    ->assertOk()
    ->assertDontSeeText($course->title);
});

it('shows latest purchased course first', function () {
    //arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->courses()->attach($firstPurchasedCourse,['created_at' =>Carbon::yesterday()]);
    $user->courses()->attach($lastPurchasedCourse,['created_at' =>Carbon::now()]);

    //act & assert
    loginAsUser($user);
    get(route('pages.dashboard'))
    ->assertOk()
    ->assertSeeTextInOrder([
        $lastPurchasedCourse->title,
        $firstPurchasedCourse->title,
    ]);
});


it('includes link to product videos', function () {
    //arrange
    $user = User::factory()
    ->has(Course::factory())->create();

    //act & assert
    loginAsUser($user);
    get(route('pages.dashboard'))
    ->assertOk()
    ->assertSeeText('Watch videos')
    ->assertSee(route('pages.course-videos',Course::first()));
});

it('includes logout', function () {
    loginAsUser();
    get(route('pages.dashboard'))
    ->assertOk()
    ->assertSeeText('Log Out')
    ->assertSee(route('logout'));
});
