<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesImages
{
    protected $imageService;

    public function __construct()
    {
        $this->imageService = app(\App\Services\ImageUploadService::class);
    }

    /**
     * Handle image upload and delete old one if exists
     */
    protected function handleImageUpload(UploadedFile $file, string $folder, ?string $oldImage = null)
    {
        // Delete old image if exists
        if ($oldImage) {
            $this->imageService->delete($oldImage);
        }

        // Upload new image
        return $this->imageService->upload($file, $folder);
    }
}