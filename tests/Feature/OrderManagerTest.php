<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class OrderManagerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        Mail::fake();
    }

    public function test_vendor_order_list_displays_orders()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create(['vendor_id' => $vendor->id]);
        $this->actingAs($vendor);
        $response = $this->get(route('vendor.orders.list'));
        $response->assertStatus(200);
        $response->assertViewHas('orders');
    }

    public function test_show_checkout_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('checkout'));
        $response->assertStatus(200);
    }

    public function test_checkout_post_creates_orders_and_redirects_to_payment()
    {
        $user = User::factory()->create();
        $vendor = User::factory()->create(['role' => 'vendor']);
        $product = Product::factory()->create(['vendor_id' => $vendor->id, 'price' => 100]);
        Cart::factory()->create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 2]);
        $this->actingAs($user);
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'address' => '123 Street',
            'city' => 'City',
            'pincode' => '123456',
            'phone' => '1234567890',
        ];
        $this->mockPaymentInitiate();
        $response = $this->post(route('checkout.post'), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['user_id' => $user->id, 'status' => 'pending']);
    }

    public function test_payment_success_updates_order_status_and_sends_receipt()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id, 'status' => 'pending']);
        $this->actingAs($user);
        $this->mockPaymentLookup('Completed', 20000);
        $response = $this->post(route('payment.success'), ['pidx' => 'test_pidx']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', ['user_id' => $user->id, 'status' => 'paid_pending_vendor']);
        Mail::assertSent(\App\Mail\PaymentReceiptMail::class);
    }

    public function test_confirm_order_by_vendor_changes_status_and_sends_mail()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $user = User::factory()->create();
        $order = Order::factory()->create(['vendor_id' => $vendor->id, 'user_id' => $user->id, 'status' => 'paid_pending_vendor']);
        $this->actingAs($vendor);
        $response = $this->post(route('vendor.order.confirm', $order->id));
        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'paid_confirmed']);
        Mail::assertSent(\App\Mail\VendorConfirmedMail::class);
    }

    public function test_cancel_order_by_user_changes_status_and_notifies()
    {
        $user = User::factory()->create();
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create(['user_id' => $user->id, 'vendor_id' => $vendor->id, 'status' => 'paid_pending_vendor']);
        $this->actingAs($user);
        $response = $this->post(route('user.order.cancel', $order->id));
        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'cancelled_by_user']);
        Notification::assertSentTo($user, \App\Notifications\OrderCancelledNotification::class);
        Notification::assertSentTo($vendor, \App\Notifications\OrderCancelledNotification::class);
    }

    public function test_cancel_order_by_vendor_changes_status_and_notifies()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $user = User::factory()->create();
        $order = Order::factory()->create(['vendor_id' => $vendor->id, 'user_id' => $user->id, 'status' => 'paid_pending_vendor']);
        $this->actingAs($vendor);
        $response = $this->post(route('vendor.order.cancel', $order->id));
        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'cancelled_by_vendor']);
        Notification::assertSentTo($user, \App\Notifications\OrderCancelledNotification::class);
    }

    private function mockPaymentInitiate()
    {
        \Illuminate\Support\Facades\Http::fake([
            env('KHALTI_API_URL') . 'epayment/initiate/' => \Illuminate\Http\Client\Response::make([
                'payment_url' => 'http://fake-payment-url.com'
            ], 200)
        ]);
    }

    private function mockPaymentLookup($status, $amount)
    {
        \Illuminate\Support\Facades\Http::fake([
            env('KHALTI_API_URL') . 'epayment/lookup/' => \Illuminate\Http\Client\Response::make([
                'status' => $status,
                'amount' => $amount
            ], 200)
        ]);
    }
// Dummy change for sequential commit generation
}