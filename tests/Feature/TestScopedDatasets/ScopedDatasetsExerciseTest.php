<?php

use App\Models\Course;
use App\Models\User;
require_once __DIR__ . '/ScopeDatasets.php';

describe('Scoped Datasets Exercise', function () {

    describe('Review Validation Tests', function () {
        it('validates review comment length and content', function ($comment) {
            $user = User::factory()->create();
            $course = Course::factory()->create();
            $user->purchasedCourses()->attach($course);

            $reviewData = [
                'course_id' => $course->id,
                'rating' => 4,
                'comment' => $comment,
            ];

            $response = $this->actingAs($user)->post(route('reviews.store'), $reviewData);

            if (empty($comment)) {
                // Commentaire vide - devrait échouer la validation
                $response->assertSessionHasErrors('comment');
            } else {
                // Commentaire valide - devrait réussir
                $response->assertRedirect();

                $review = $course->reviews()->first();
                expect($review)->not->toBeNull();
                expect($review->comment)->toBe($comment);
            }
        })->with('review_comments');
    });

    describe('Course Pricing Tests', function () {
        it('calculates final price with discounts correctly', function ($pricingData) {
            $course = Course::factory()->create([
                'price' => $pricingData['price'],
                'discount_percentage' => $pricingData['discount']
            ]);

            $finalPrice = $course->getFinalPrice();

            expect(round($finalPrice, 2))->toBe(round($pricingData['expected_final'], 2));

            // Vérifications supplémentaires
            if ($pricingData['discount'] > 0) {
                expect($course->hasDiscount())->toBeTrue();
                expect($course->getSavingsAmount())->toBe(round($pricingData['price'] - $pricingData['expected_final'], 2, PHP_ROUND_HALF_DOWN));
            } else {
                expect($course->hasDiscount())->toBeFalse();
            }
        })->with('pricing_strategies');
    });

    describe('User Permission Tests', function () {
        it('enforces correct review permissions', function ($scenario) {
            $course = Course::factory()->create();

            if (!$scenario['authenticated']) {
                // Utilisateur non authentifié
                $response = $this->post(route('reviews.store'), [
                    'course_id' => $course->id,
                    'rating' => 5,
                    'comment' => 'Test review',
                ]);

                $response->assertRedirect(route('login'));
                return;
            }

            // Utilisateur authentifié
            $user = User::factory()->create(['role' => $scenario['role']]);

            // Si l'utilisateur peut faire une review, simuler l'achat
            if ($scenario['can_review'] ) {
                $user->purchasedCourses()->attach($course);
            }

            $response = $this->actingAs($user)->post(route('reviews.store'), [
                'course_id' => $course->id,
                'rating' => 5,
                'comment' => 'Test review',
            ]);

            if ($scenario['can_review']) {
                $response->assertRedirect(route('pages.home'));
                expect($course->reviews()->count())->toBe(1);
            } else {
                $response->assertStatus(403); // Forbidden
            }
        })->with('permission_scenarios');
    });
});
