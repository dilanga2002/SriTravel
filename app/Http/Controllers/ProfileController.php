<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\UpdatesProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use UpdatesProfile;

    /**
     * Show Profile (Role-based view)
     */
    public function show()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return view('admin.profile.show', compact('user'));
        } elseif ($user->isDriver()) {
            return view('driver.profile.show', compact('user'));
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Update Profile + Password (Single endpoint)
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Handle Password Change
        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password'         => ['required', 'confirmed', 'min:8'],
            ]);

            $user->update([
                'password' => bcrypt($request->password)
            ]);

            return back()->with('success', 'Password updated successfully.');
        }

        // Normal Profile Update
        return $this->updateProfile($request);
    }

    /**
     * Delete Account
     */
    public function destroy(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return back()->with('error', 'Admin accounts cannot be deleted this way.');
        }

        return $this->deleteAccount($request);
    }

    protected function deleteAccount(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        try {
            if ($user->profile_photo) {
                app(\App\Services\ImageUploadService::class)->delete($user->profile_photo);
            }

            $user->delete();
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete account.');
        }
    }
}