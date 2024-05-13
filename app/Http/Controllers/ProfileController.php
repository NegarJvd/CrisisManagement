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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

        foreach ($user->designs as $design)
        {
            $design->woods()->sync([]);
            $design->machines()->sync([]);
            if ($design->file_path)
            {
                $path = public_path('storage/'.$design->file_path);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }
        $user->designs()->delete();

        foreach ($user->timber_supplies as $timber)
        {
            $timber->woods()->sync([]);
        }
        $user->timber_supplies()->delete();

        foreach ($user->cnc_supplies as $cnc)
        {
            $cnc->machines()->sync([]);
        }
        $user->cnc_supplies()->delete();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
