<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
{
    $user = $request->user();

    // Choose layout based on user role
    if ($user->isAdmin()) {
        $layout = 'layouts.admin-layout';
    } elseif ($user->isVendor()) {
        $layout = 'layouts.app'; // vendor layout is 'app'
    } else {
        $layout = 'layouts.user-layout';
    }

    return view('profile.edit', [
        'user' => $user,
        'layout' => $layout
    ]);
}
