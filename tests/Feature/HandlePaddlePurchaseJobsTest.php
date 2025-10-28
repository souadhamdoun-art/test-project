<?php
namespace Tests\Feature;

use App\Jobs\HandlePaddlePurchaseJob;
use App\Models\Course;
use App\Models\PurchasedCourse;
use App\Models\User;
use App\Mail\NewPurchaseMail;
use Illuminate\Support\Facades\Mail;
use Spatie\WebhookClient\Models\WebhookCall;


beforeEach(function () {
    $this->dummyWebhookCall = WebhookCall::create([
        'name' => 'default',
        'url' => 'http://example.com',
        'payload' => [
            'email' => 'test@test.at',
            'name' => 'test user',
            'p_product_id' => '123456',
        ],
    ]);
});

it('stores paddle purchase', function () {

    //assert
    $this->assertDatabaseCount(User::class,0);
    $this->assertDatabaseCount(PurchasedCourse::class,0);

    //arrange
    $course = Course::factory()->create(['paddle_product_id'=>'123456']);

    //act
    (new HandlePaddlePurchaseJob($this->dummyWebhookCall))->handle();
    //assert
    $this->assertDatabaseHas(User::class, [
        'email' => 'test@test.at',
        'name' => 'test user',
    ]);
    $user = User::where('email', 'test@test.at')->first();
    $this->assertDatabaseHas(PurchasedCourse::class, [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

});




it('sends out purchase email', function () {
    Mail::fake();

    $course = Course::factory()->create(['paddle_product_id'=>'123456']);
 
    //act
    (new HandlePaddlePurchaseJob($this->dummyWebhookCall))->handle();

    //assert
    Mail::assertSent(NewPurchaseMail::class);



});
