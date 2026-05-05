<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($user->role !== 'admin') {
            $user->can_switch_role = $request->has('can_switch_role');
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
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
    /**
     * Switch the user's role between employer and employee.
     */
    public function switchRole(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return Redirect::back()->with('error', 'Admins cannot switch roles.');
        }

        if (!$user->can_switch_role) {
            return Redirect::back()->with('error', 'You must enable the "I want to be both" option in your profile to switch roles.');
        }

        $user->role = ($user->role === 'employer') ? 'employee' : 'employer';
        $user->save();

        $roleName = ucfirst($user->role);
        return Redirect::back()->with('status', "Role switched to {$roleName}.");
    }
}
