<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class VendorController extends Controller
{
    public function dashboard()
    {
        return view('vendor.dashboard');
    }

    public function vendorOrders()
    {
        // Get orders for this vendor's products
        $orders = Order::whereHas('product', function ($query) {
            $query->where('vendor_id', Auth::id()); // Only get orders for the vendor's products
        })->get();

        return view('vendor.orders.list', compact('orders'));
    }

    public function showOrder($orderId)
    {
        $order = Order::findOrFail($orderId); // Corrected class name
        return view('vendor.orders.show', compact('order')); // Corrected variable name
    }


    public function create()
{
    $categories = Category::all(); // Get all categories
    return view('vendor.products.create', compact('categories'));
}

public function edit(Product $product)
{
    $categories = Category::all(); // Get all categories
    return view('vendor.products.edit', compact('product', 'categories'));
}

}