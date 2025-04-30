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


    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $data['image'] = $path;
        }

        if ($user->email !== $data['email']) {
            $user->email_verified_at = null;
        }

        $user->fill($data)->save();

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully!');
    }
}
