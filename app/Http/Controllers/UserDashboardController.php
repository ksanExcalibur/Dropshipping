<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('userpage.dashboard');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('userpage.orders', compact('orders'));
    }
}
