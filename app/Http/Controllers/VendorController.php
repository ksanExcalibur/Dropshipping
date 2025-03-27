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

     

}