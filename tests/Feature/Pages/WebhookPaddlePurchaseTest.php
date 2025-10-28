<?php
namespace Tests\Feature\Pages;

use App\Jobs\HandlePaddlePurchaseJob;
use Illuminate\Support\Facades\Queue;
use Spatie\WebhookClient\Models\WebhookCall;

// it('stores a paddle purchase request', function () {
//     // Arrange
//     expect(WebhookCall::count())->toBe(0);

//     // Act
//     $response = $this->withHeaders([
//         'Signature' => 'test-signature',
//     ])->post('webhooks', [
//         'event_time' => now()->toDateTimeString(),
//         'p_country' => 'US',
//         'p_coupon' => null,
//         'p_coupon_savings' => 0,
//     ]);

//     // Debug the response
//     if ($response->status() !== 200) {
//         dump('Response status: ' . $response->status());
//         dump('Response content: ' . $response->content());
//     }

//     // Assert
//     expect(WebhookCall::count())->toBe(1);
// });


it('does not store invalid paddle purchase requests', function () {
    // Arrange
    $this->assertDatabaseCount(WebhookCall::class, 0);

    // Act
    $this->post('webhooks', [
        'event_time' => now()->toDateTimeString(),
        'p_country' => 'US',
        'p_coupon' => null,
        'p_coupon_savings' => 0,
        'p_currency' => 'USD',
        'p_custom_data' => '{"4736":"55.5500"}',
        'p_order_id' => '123456',
        'p_paddle_fee'=>'3.45',
        'p_price'=>'59',
        'p_product_id'=>'4736',
        'p_quantity'=>'1',
        'p_sale_gross'=>'59',
        'p_tax_amount'=>'0',
        'p_used_price_override'=>'1',
        'passthrough'=>'Example passthrough',
        'quantity'=>'1',
        'p_discount' => 0,
        'p_discount_savings' => 0,
        'p_email' => 'test@example.com',
        'p_ip' => '127.0.0.1',
        'p_name' => 'Test User',
        'p_order_id' => '123456',
        'p_payment_id' => '123456',
        'p_payment_method' => 'credit_card',
        'p_payment_status' => 'completed',
        'p_payment_type' => 'sale',
        'p_price' => 10,
        'p_quantity' => 1,
        'p_signature'=>'test-signature',

    ]);

    // Assert
    $this->assertDatabaseCount(WebhookCall::class, 0);
});


// it('dispatches a job for valid paddle request', function () {
//     // Arrange
//     Queue::fake();
//     // Act
//      $this->post('webhooks', [
//         'event_time' => now()->toDateTimeString(),
//         'p_country' => 'US',
//         'p_coupon' => null,
//         'p_coupon_savings' => 0,
//         'p_currency' => 'USD',
//         'p_custom_data' => '{"4736":"55.5500"}',
//         'p_order_id' => '123456',
//         'p_paddle_fee'=>'3.45',
//         'p_price'=>'59',
//         'p_product_id'=>'4736',
//         'p_quantity'=>'1',
//         'p_sale_gross'=>'59',
//         'p_tax_amount'=>'0',
//         'p_used_price_override'=>'1',
//         'passthrough'=>'Example passthrough',
//         'quantity'=>'1',
//         'p_discount' => 0,
//         'p_discount_savings' => 0,
//         'p_email' => 'test@example.com',
//         'p_ip' => '127.0.0.1',
//         'p_name' => 'Test User',
//         'p_order_id' => '123456',
//         'p_payment_id' => '123456',
//         'p_payment_method' => 'credit_card',
//         'p_payment_status' => 'completed',
//         'p_payment_type' => 'sale',
//         'p_price' => 10,
//         'p_quantity' => 1,
//         'p_signature'=>'test-signature',

//     ]);
//     // Assert
//     Queue::assertPushed(HandlePaddlePurchaseJob::class);
// });


it('does not dispatch a job for invalid paddle request', function () {
    // Arrange
    Queue::fake();
    // Act
    $this->post('webhooks',[]);

    // Assert
    Queue::assertNotPushed(HandlePaddlePurchaseJob::class);
});
