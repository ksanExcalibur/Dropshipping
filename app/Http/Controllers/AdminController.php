<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all orders with their associated user and product in one query (eager loading)
        $orders = Order::with(['user', 'product'])->latest()->get();

        // Fetch all products
        $products = Product::latest()->get();

        // Fetch all vendors (users with 'vendor' role)
        $vendors = User::where('role', 'vendor')->latest()->get();

        // Pass data to the admin dashboard view
        return view('admin.admin_home', compact('orders', 'products', 'vendors'));
    }

    public function showOrders()
    {
        // Fetch all orders with their associated user and product in one query (eager loading)
        $orders = Order::with(['user', 'product'])->latest()->get();

        // Return the view for admin orders history
        return view('admin.orders.history', compact('orders'));
    }
}
