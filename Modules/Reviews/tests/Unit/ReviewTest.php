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

it('isApproved returns true only when status is approved', function () {
    $review = Review::factory()->approved()->create();
    expect($review->isApproved())->toBeTrue();
});

it('reject method changes status to rejected', function () {
    $review = Review::factory()->create();
    $review->reject();
    expect($review->status)->toBe('rejected');
});


it('scopeApproved filters only approved reviews', function () {
    $approvedReview = Review::factory()->approved()->create();
    $pendingReview = Review::factory()->pending()->create();
    $rejectedReview = Review::factory()->rejected()->create();
    expect(Review::approved()->count())->toBe(1);
});

it('scopeRecent orders by created_at desc', function () {
    $review1 = Review::factory()->create([
        'created_at' => now()->subDays(1),
    ]);
    $review2 = Review::factory()->create([
        'created_at' => now()->subDays(2),
    ]);
    $review3 = Review::factory()->create([
        'created_at' => now()->subDays(3),
    ]);
    $reviews = Review::recent()->get();
    expect($reviews)->toHaveCount(3);
    expect($reviews->first()->id)->toBe($review1->id);
    expect($reviews->last()->id)->toBe($review3->id);
});
