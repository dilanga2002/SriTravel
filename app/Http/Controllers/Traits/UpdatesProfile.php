<?php

namespace App\Http\Controllers\Traits;

use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait UpdatesProfile
{
    protected $imageService;

    public function __construct()
    {
        $this->imageService = app(ImageUploadService::class);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Handle profile photo
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    $this->imageService->delete($user->profile_photo);
                }
                $validated['profile_photo'] = $this->imageService->upload($request->file('profile_photo'), 'profile-photos');
            }

            $user->update($validated);

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile.');
        }
    }
}