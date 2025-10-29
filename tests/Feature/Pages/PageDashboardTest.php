<?php
namespace Tests\Feature\Pages;

use function Pest\Laravel\get;

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Juampi92\TestSEO\TestSEO;

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
       ),'purchasedCourses')
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

    $user->purchasedCourses()->attach($firstPurchasedCourse,['created_at' =>Carbon::yesterday()]);
    $user->purchasedCourses()->attach($lastPurchasedCourse,['created_at' =>Carbon::now()]);

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
    ->has(Course::factory(),'purchasedCourses')->create();

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

it('includes link to course details', function () {
    //arrange
     $firstCourse = Course::factory()->released()->create();
     $secondCourse = Course::factory()->released()->create();
     $lastCourse = Course::factory()->released()->create();

    //act & assert
   get(route('pages.home'))
   ->assertOk()
   ->assertSee([
      route('pages.course-details',$firstCourse),
      route('pages.course-details',$secondCourse),
      route('pages.course-details',$lastCourse),
   ]);
});

it('includes title',function(){
    //arrange

    $expectedTitle = config('app.name'). ' - Home';

    //act
    $response = get(route('pages.home'))->assertOk();
    //assertion
    $seo = new TestSEO($response->getContent());
    expect($seo->data)
    ->title()->toBe($expectedTitle);


});


it('includes social tags', function () {

    //act & assert
    $response = get(route('pages.home'))->assertOk();
    $seo = new TestSEO($response->getContent());
    expect($seo->data)
    ->description()->toBe('LaravelCasts is the learning platform for Laravel developers')
    ->openGraph()->type->toBe('website')
    ->openGraph()->url->toBe(route('pages.home'))
    ->openGraph()->title->toBe('LaravelCasts')
    ->openGraph()->description->toBe('LaravelCasts is the learning platform for Laravel developers')
    ->openGraph()->image->toBe(asset('images/social.png'));

});
