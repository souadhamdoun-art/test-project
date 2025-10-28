<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Mail\NewPurchaseMail;

it('includes purchase details', function () {
    //arrange
    $course = Course::factory()->create();
    //act
    $mail = new NewPurchaseMail($course);
    //assert
    $mail->assertSeeInText("Thanks for purchasing $course->title");
    $mail->assertSeeInText("Login");
    $mail->assertSeeInHtml(route('login'));

});
