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

    public function viewReceipt($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('emails.payment_receipt', compact('order'));
    }

    public function sendPaymentReceipt($order)
    {
        try {
            Mail::to(Auth::user()->email)->send(new PaymentReceiptMail($order));
            \Log::info('Payment receipt email sent to:', ['email' => Auth::user()->email]);
        } catch (\Exception $e) {
            \Log::error('Failed to send email:', ['error' => $e->getMessage()]);
        }
    }

    public function confirmOrderByVendor($orderId)
    {
        $order = Order::where('id', $orderId)
                      ->where('vendor_id', Auth::id())
                      ->where('status', 'paid_pending_vendor')
                      ->first();

        if (!$order) {
            return back()->with('error', 'Order not found or already confirmed.');
        }

        $order->status = 'paid_confirmed';
        $order->save();

        Mail::to($order->user->email)->send(new VendorConfirmedMail($order));

        return back()->with('success', 'Order has been confirmed successfully.');
    }

    //  NEW: Cancel Order by User
    public function cancelOrderByUser($orderId)
    {
        $order = Order::findOrFail($orderId);
    
        if ($order->status == 'paid_pending_vendor') {
            // Update order status to cancelled
            $order->status = 'cancelled_by_user';
            $order->save();
    
            // Notify the user about the cancellation
            if (Auth::check()) {
                Auth::user()->notify(new OrderCancelledNotification($order));
            } else {
                return redirect()->route('login')->with('error', 'You must be logged in to cancel the order.');
            }
    
            // Optionally, you can notify the vendor as well
            if ($order->vendor) {
                $order->vendor->notify(new OrderCancelledNotification($order));
            } else {
                \Log::warning('Order has no associated vendor', ['order_id' => $order->id]);
            }
    
            return redirect()->route('user.orders')->with('success', 'Order has been cancelled successfully.');
        }
    
        return redirect()->route('user.orders')->with('error', 'Order cannot be cancelled at this stage.');
    }
    

    //  NEW: Cancel Order by Vendor
    public function cancelOrderByVendor($orderId)
    {
        $order = Order::where('id', $orderId)
                      ->where('vendor_id', Auth::id())
                      ->where('status', 'paid_pending_vendor')
                      ->first();

        if (!$order) {
            return back()->with('error', 'Order cannot be cancelled.');
        }

        $order->status = 'cancelled_by_vendor';
        $order->save();

        // Notify user and admins
        $user = User::find($order->user_id);
        if ($user) {
            $user->notify(new OrderCancelledNotification($order));
        }

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new OrderCancelledNotification($order));
        }

        return back()->with('success', 'Order cancelled successfully.');
    }
}
