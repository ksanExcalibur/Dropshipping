<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewUserRegisteredNotification;



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
//registration
    // Handle registration post request
    public function registrationPost(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
            'role' => 'nullable|in:user,vendor',
            'admin_code' => 'nullable|string'
        ]);
    
        $role = 'user'; // Default role
    
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
    
        if ($user) {
            // Send notification to all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewUserRegisteredNotification($user));
            }
        } else {
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

    // Show forgot password form
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Handle forgot password request
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Show reset password form
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect('login')->with('success', 'Password reset successfully. Please login with your new password.')
            : back()->withErrors(['email' => __($status)]);
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

