<?php

namespace App\Services;   // ← This must be App\Services

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    protected $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function update(User $user, array $validated, ?UploadedFile $photo = null): void
    {
        $data = [];

        if (!empty($validated['name'])) {
            $data['name'] = $validated['name'];
        }
        if (!empty($validated['email'])) {
            $data['email'] = $validated['email'];
        }
        if (!empty($validated['phone'])) {
            $data['phone'] = $validated['phone'];
        }
        if (!empty($validated['address'])) {
            $data['address'] = $validated['address'];
        }

        if ($photo) {
            $data['profile_photo'] = $this->imageService->upload(
                $photo,
                'profile_photos',
                $user->profile_photo
            );
        }

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if (!empty($data)) {
            $user->update($data);
        }
    }
}