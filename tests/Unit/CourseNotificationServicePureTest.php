<?php

use App\Services\CourseNotificationService;
use App\Services\Calculator;
use App\TwitterClient;
use App\Models\Course;
use App\Models\User;
use Mockery;

// VRAI test unitaire - aucune dépendance Laravel
test('pure unit test - logic only', function () {
    // Arrange - Mocker TOUTES les dépendances
    $twitterMock = Mockery::mock(TwitterClient::class);
    $calculatorMock = Mockery::mock(Calculator::class);
    
    // Pas d'expectation car < 5 users (pas de Twitter)
    // Pas d'expectation car < 10 users (pas de Calculator)
    
    $service = new CourseNotificationService($twitterMock, $calculatorMock);
    
    // Créer des objets simples SANS base de données
    $course = new Course();
    $course->title = 'Test Course';
    $course->id = 1;
    
    $user1 = new User();
    $user1->email = 'user1@test.com';
    $user1->id = 1;
    
    $user2 = new User();
    $user2->email = 'user2@test.com';
    $user2->id = 2;
    
    $users = [$user1, $user2];

    // Mock Mail facade (plus complexe)
    $mailMock = Mockery::mock('alias:Illuminate\Support\Facades\Mail');
    $mailMock->shouldReceive('raw')->times(2);

    // Act
    $result = $service->notifyNewCourse($course, $users);

    // Assert - Tester SEULEMENT la logique métier
    expect($result['total_users'])->toBe(2);
    expect($result['twitter_posted'])->toBeFalse(); // < 5 users
    expect($result['discount_applied'])->toBeFalse(); // < 10 users
    // Note: email_sent dépend de Mail::raw qui est mocké
});
