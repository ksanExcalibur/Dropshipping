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

        // Fetch all users
        $users = User::latest()->get();

        // Pass data to the admin dashboard view
        return view('admin.admin_home', compact('orders', 'products', 'vendors', 'users'));
    }

    public function showOrders()
    {
        // Fetch all orders with their associated user and product in one query (eager loading)
        $orders = Order::with(['user', 'product'])->latest()->get();

        // Return the view for admin orders history
        return view('admin.orders.history', compact('orders'));
    }

    public function chat()
    {
        return view('admin.chat');
    }

    // Vendor Management Methods
    public function editVendor(User $vendor)
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function updateVendor(Request $request, User $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$vendor->id,
        ]);

        $vendor->update($validated);
        return redirect()->route('admin.dashboard')->with('success', 'Vendor updated successfully');
    }

    public function destroyVendor(User $vendor)
    {
        $vendor->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Vendor deleted successfully');
    }

    // User Management Methods
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($validated);
        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
