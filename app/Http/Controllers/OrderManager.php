<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\PaymentReceiptMail;
use App\Mail\VendorConfirmedMail;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\OrderCancelledNotification;
use App\Models\User;

class OrderManager extends Controller
{
    public function vendorOrderList()
    {
        $orders = Order::where('vendor_id', Auth::id())->get();
        return view('vendor.orders.list', compact('orders'));
    }

    public function showCheckout()
    {
        return view('backend.checkout');
    }

    public function checkoutPost(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'phone' => 'required',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalAmount = 0;

        foreach ($cartItems as $cartItem) {
            $order = new Order();
            $order->user_id = Auth::id();
            $order->product_id = $cartItem->product_id;
            $order->qty = $cartItem->quantity;
            $order->price = $cartItem->product->price * $cartItem->quantity;
            $order->address = $request->address;
            $order->pincode = $request->pincode;
            $order->city = $request->city;
            $order->phone = $request->phone;
            $order->status = 'pending';

            $product = Product::find($cartItem->product_id);
            $order->vendor_id = $product->vendor_id;
            $order->customer_name = $request->name;
            $order->product_name = $product->name;

            $order->save();
            $totalAmount += $order->price;

            // Send notification to vendor
            $vendor = User::find($order->vendor_id);
            if ($vendor) {
                $vendor->notify(new OrderPlacedNotification($order));
            }

            // Send notification to user
            $order->user->notify(new OrderPlacedNotification($order));

            // Send notification to all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new OrderPlacedNotification($order));
            }
        }

        Cart::where('user_id', Auth::id())->delete();

        if ($totalAmount > 0) {
            return $this->initiatePayment($totalAmount);
        }

        return redirect()->route('cart.index')->with('error', 'Order creation failed.');
    }

    public function initiatePayment($amount)
    {
        $amountInPaisa = $amount * 100;

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('KHALTI_API_URL') . 'epayment/initiate/', [
            'return_url' => route('payment.success'),
            'website_url' => config('app.url'),
            'amount' => $amountInPaisa,
            'purchase_order_id' => 'order_' . Auth::id(),
            'purchase_order_name' => 'Order from User ' . Auth::id(),
        ]);

        if ($response->successful()) {
            $paymentData = $response->json();
            return redirect($paymentData['payment_url']);
        }

        return back()->with('error', 'Payment initiation failed. Please try again.');
    }

    public function paymentSuccess(Request $request)
    {
        $pidx = $request->pidx;

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('KHALTI_API_URL') . 'epayment/lookup/', [
            'pidx' => $pidx,
        ]);

        if ($response->successful()) {
            $verificationData = $response->json();

            \Log::info('Khalti API Response:', $verificationData);

            if (isset($verificationData['status']) && $verificationData['status'] === 'Completed') {
                Order::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->update(['status' => 'paid_pending_vendor']);

                $order = Order::where('user_id', Auth::id())
                            ->where('status', 'paid_pending_vendor')
                            ->latest()
                            ->first();

                if ($order) {
                    $this->sendPaymentReceipt($order);
                }

                Cart::where('user_id', Auth::id())->delete();

                if (isset($verificationData['amount'])) {
                    $amount = $verificationData['amount'] / 100;
                    return view('backend.payment.success', compact('amount'));
                }

                return redirect()->route('orders.index')->with('success', 'Payment verified, but no amount found.');
            }

            return redirect()->route('orders.index')->with('error', 'Payment not completed.');
        }

        return redirect()->route('orders.index')->with('error', 'Payment verification failed.');
    }

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $orders = Order::all();
        } elseif (Auth::user()->isVendor()) {
            $orders = Order::where('vendor_id', Auth::id())->get();
        } else {
            $orders = Order::where('user_id', Auth::id())->get();
        }

        return view('userpage.orders', compact('orders'));
    }
