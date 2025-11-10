<?php

use App\Models\Course;
use App\Models\User;
use App\Services\CourseNotificationService;
use App\Services\Calculator;
use App\TwitterClient;
use Illuminate\Support\Facades\Mail;
use Mockery;

test('basic notification service test', function () {
    // Arrange
    Mail::fake();

    // Créer des mocks simples
    $twitterMock = Mockery::mock(TwitterClient::class);
    $calculatorMock = Mockery::mock(Calculator::class);

    $service = new CourseNotificationService($twitterMock, $calculatorMock);

    // Créer des objets simples au lieu d'utiliser les factories
    // $course = new Course();
    // $course->id = 1;
    // $course->title = 'Test Course';
    // $course->price = 100;
    // $course->is_premium = false;

    // $user1 = new User();
    // $user1->id = 1;
    // $user1->email = 'user1@test.com';

    // $user2 = new User();
    // $user2->id = 2;
    // $user2->email = 'user2@test.com';

    // $users = [$user1, $user2];

    $course = Course::factory()->create();
    $users = User::factory()->count(3)->create();

    // Act
    $result = $service->notifyNewCourse($course, $users->toArray());

    // Assert - vérifier la logique métier de base
    expect($result['total_users'])->toBe(3);
    expect($result['twitter_posted'])->toBeFalse(); // < 5 users
    expect($result['discount_applied'])->toBeFalse(); // < 10 users

    // Le test principal : vérifier que les emails sont comptés
    expect($result['email_sent'])->toBe(3);
});
