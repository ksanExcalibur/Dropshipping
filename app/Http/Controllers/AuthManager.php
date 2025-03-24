<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    // Show login form
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectUser(Auth::user());
        }
        return view('login');
    }

    // Show registration form
    public function registration()
    {
        return view('registration');
    }

    // Handle login post request
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectUser(Auth::user())->with('success', 'Logged in successfully');
        }

        return redirect('login')->with('error', 'Invalid credentials');
    }

    // Handle registration post request
    public function registrationPost(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'password' => 'required|min:6|confirmed', // Requires password_confirmation
            'role' => 'nullable|in:user,vendor', 
            'admin_code' => 'nullable|string'
        ]);

        $role = 'user'; // Default role

        // Admin code check
        if ($request->filled('admin_code') && $request->admin_code === env('ADMIN_SECRET_CODE')) {
            $role = 'admin';
        } elseif ($request->filled('role') && $request->role === 'vendor') {
            $role = 'vendor';
        }

        $user = User::create([
            'name' => $request->fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $role
        ]);

        if (!$user) {
            return redirect('registration')->with('error', 'Registration failed');
        }

        return redirect('login')->with('success', ucfirst($role) . ' registration successful');
    }

    // Handle logout
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login')->with('success', 'Logged out successfully');
    }

    // Role-based redirection helper
    private function redirectUser($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
}
