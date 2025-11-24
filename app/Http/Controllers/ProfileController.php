<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweet;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * PUBLIC PROFILE PAGE (show tweets of any user)
     */
    public function show(User $user): View
    {
        $user->load('tweets.likes', 'groups');
        $tweets = $user->tweets()->orderBy('created_at', 'desc')->get();
        
        // Load user's owned circles with pending requests
        $ownedCircles = \App\Models\Group::where('user_id', $user->id)
            ->with(['pendingRequests'])
            ->get();
        
        return view('profile.show', compact('user', 'tweets', 'ownedCircles'));
    }

    /**
     * Logged-in user edit profile page
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update logged-in user profile details
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete user account
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
