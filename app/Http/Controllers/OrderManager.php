<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Http;
use Auth;
use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Mail;

class OrderManager extends Controller
{
    // Function for displaying the Vendor's Order List
    public function vendorOrderList()
    {
        // Fetch orders for the vendor (orders linked to the vendor's products)
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
        'status' => 'nullable'
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
        $order->status = 'pending'; // Set initial status to 'pending'

        // Add vendor_id to the order
        $product = Product::find($cartItem->product_id);
        $order->vendor_id = $product->vendor_id;

        // Optionally, add customer_name and product_name if needed
        $order->customer_name = $request->name;
        $order->product_name = $product->name;

        $order->save();

        $totalAmount += $order->price;
    }

    // Clear the cart after the order is successfully placed
    Cart::where('user_id', Auth::id())->delete();

    if ($totalAmount > 0) {
        return $this->initiatePayment($totalAmount);
    }

    return redirect()->route('cart.index')->with('error', 'Order creation failed');
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
        'purchase_order_id' => 'order_' . Auth::id(), // Use user ID as a reference
        'purchase_order_name' => 'Order from User ' . Auth::id(),
    ]);

    if ($response->successful()) {
        $paymentData = $response->json();
        return redirect($paymentData['payment_url']);
    } else {
        return back()->with('error', 'Payment initiation failed. Please try again.');
    }
}

    public function verifyPayment(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('KHALTI_API_URL') . 'epayment/lookup/', [
            'pidx' => $request->pidx,
        ]);

        if ($response->successful()) {
            $verificationData = $response->json();

            if ($verificationData['status'] === 'Completed') {
                // Update orders with the matching pidx to 'paid' status
                Order::where('user_id', Auth::id()) // Check orders for the current user
                    ->where('status', 'pending')
                    ->update(['status' => 'paid']);

                return redirect()->route('orders.index')->with('success', 'Payment successful!');
            }
        }

        return redirect()->route('orders.index')->with('error', 'Payment verification failed.');

        
    }
    public function paymentSuccess(Request $request)
    {
        $pidx = $request->pidx;
    
        // Verify the payment with Khalti
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('KHALTI_API_URL') . 'epayment/lookup/', [
            'pidx' => $pidx,
        ]);
    
        if ($response->successful()) {
            $verificationData = $response->json();
    
            // Log the entire response from Khalti
            \Log::info('Khalti API Response:', $verificationData);
    
            if (isset($verificationData['status']) && $verificationData['status'] === 'Completed') {
                // Update all pending orders for the current user to 'paid'
                Order::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->update(['status' => 'paid']);
    
                // Send the payment receipt email
                $order = Order::where('user_id', Auth::id())->where('status', 'paid')->first();
                if ($order) {
                    $this->sendPaymentReceipt($order);
                }
    
                // Clear the cart after successful payment
                Cart::where('user_id', Auth::id())->delete();
    
                // Proceed with displaying success page
                if (isset($verificationData['amount'])) {
                    $amount = $verificationData['amount'] / 100; // Convert from paisa to the original amount
                    return view('backend.payment.success', compact('amount'));
                } else {
                    \Log::error('Amount key missing in Khalti response:', $verificationData);
                    return redirect()->route('orders.index')->with('error', 'Payment verification failed: Amount not found.');
                }
            } else {
                \Log::error('Payment status not completed:', $verificationData);
                return redirect()->route('orders.index')->with('error', 'Payment verification failed: Status not completed.');
            }
        } else {
            \Log::error('Khalti API request failed:', ['response' => $response->body()]);
            return redirect()->route('orders.index')->with('error', 'Payment verification failed: Unable to verify payment.');
        }
    }
    

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            // Admin sees all orders
            $orders = Order::all();
        } elseif (Auth::user()->isVendor()) {
            // Vendor sees only orders for their products
            $orders = Order::where('vendor_id', Auth::id())->get();
        } else {
            // Regular user sees only their own orders
            $orders = Order::where('user_id', Auth::id())->get();
        }

        return view('userpage.orders', compact('orders'));
    }
    // In OrderManager controller
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


}