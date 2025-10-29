<?php

namespace Modules\Reviews\tests\Unit;

use App\Models\User;
use App\Models\Course;
use Modules\Reviews\Models\Review;

it('belongs to a user', function () {
    $review = Review::factory()->create();
    expect($review->user)->toBeInstanceOf(User::class);
});

it('belongs to a course', function () {
    $review = Review::factory()->create();
    expect($review->course)->toBeInstanceOf(Course::class);
});

it('casts rating to integer', function () {
    $review = Review::factory()->create([
        'rating' => '5',
    ]);
    expect($review->rating)->toBeInt();
});

it('defaults status to pending', function () {
    $review = Review::factory()->create();
    expect($review->status)->toBe('pending');
});

it('can create approved review', function () {
    $review = Review::factory()->approved()->create();
    expect($review->status)->toBe('approved');
});

it('can create rejected review', function () {
    $review = Review::factory()->rejected()->create();
    expect($review->status)->toBe('rejected');
});
