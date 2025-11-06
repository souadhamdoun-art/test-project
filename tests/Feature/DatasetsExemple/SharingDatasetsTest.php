<?php

use App\Models\Course;
use App\Models\PurchasedCourse;
use App\Models\User;

// Charger les datasets partagés
require_once __DIR__ . '/../../Datasets/SharedDatasets.php';

describe('Sharing Datasets Exercise', function () {
    it('validates course difficulty requirements with named dataset', function ($level, $min_rating) {
        $course = Course::factory()->create([
            'difficulty' => $level  
        ]);
        expect($course->difficulty)->toBe($level);
        expect($course->getMinimumRatingForDifficulty())->toBe($min_rating);
    })->with('difficulty_levels');


    it('calculates correct fees for payment methods', function ($paymentData) {
        $amount = 100.00;
        $expectedFee = $amount * ($paymentData['fee'] / 100);
        $calculatedFee = calculatePaymentFee($amount, $paymentData['method']);

        expect($calculatedFee)->toBe($expectedFee);
        expect($paymentData['method'])->toBeIn(['credit_card', 'paypal', 'bank_transfer']);
    })->with('payment_methods');


    it('handles order status transaction correctly', function ($status) {
        $order = PurchasedCourse::factory()->create([
            'status' => $status
        ]);
        expect($order->status)->toBe($status);
    })->with('order_statuses');

});

function calculatePaymentFee($amount, $method) {
    $fees = [
        'credit_card' => 2.9,
        'paypal' => 3.4,
        'bank_transfer' => 0.5
    ];

    return $amount * ($fees[$method] / 100);
}
