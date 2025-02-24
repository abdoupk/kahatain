<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProfileUpdateRequest;
use App\Http\Resources\ProfileShowResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): Response
    {
        return Inertia::render('Profile/TheProfilePage', [
            'data' => new ProfileShowResource(
                auth()->user()->load('competences')
            ),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): \Illuminate\Http\Response
    {
        $request->user()?->update($request->except('competences'));

        if ($request->competences) {
            syncCompetences($request->competences, $request->user());
        }

        if ($request->user()?->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()?->save();

        return response('', 204);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user?->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(route('login', absolute: false));
    }
}
