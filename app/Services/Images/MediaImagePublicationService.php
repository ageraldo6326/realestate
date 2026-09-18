<?php

namespace App\Services\Images;

use App\Models\MediaImage;
use Illuminate\Support\Facades\Storage;

class MediaImagePublicationService
{
    public function publishWebp(MediaImage $image, string $profile): void
    {
        if ($image->slot === null || $image->imageable === null) {
            return;
        }

        $variant = $image->variants()->where('profile', $profile)->where('format', 'webp')->orderByDesc('width')->first();
        if ($variant === null) {
            return;
        }

        $image->imageable->setAttribute($image->slot, Storage::disk($variant->disk)->url($variant->path));
        $image->imageable->saveQuietly();
    }
}
