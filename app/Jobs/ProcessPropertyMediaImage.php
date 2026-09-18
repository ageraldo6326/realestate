<?php

namespace App\Jobs;

use App\Models\MediaImage;
use App\Models\Propiedad;
use App\Services\Images\ImageProcessingService;
use App\Services\Images\PropertyImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessPropertyMediaImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = [60, 120, 300];

    public function __construct(private int $mediaImageId)
    {
    }

    public function handle(ImageProcessingService $processor, PropertyImageService $propertyImages): void
    {
        $image = MediaImage::find($this->mediaImageId);
        if ($image === null || $image->imageable_type !== Propiedad::class || $image->slot === null) {
            return;
        }

        if (MediaImage::whereKey($image->id)->where('status', MediaImage::STATUS_PENDING)->update(['status' => MediaImage::STATUS_PROCESSING]) !== 1) {
            return;
        }

        foreach ($propertyImages->profilesFor($image->slot) as $profile) {
            $processor->process($image, $profile);
        }

        $fallback = $image->variants()
            ->where('profile', $propertyImages->primaryProfile($image->slot))
            ->where('format', 'webp')
            ->orderByDesc('width')
            ->firstOrFail();

        $property = $image->imageable;
        $property->setAttribute($image->slot, Storage::disk($fallback->disk)->url($fallback->path));
        $property->saveQuietly();
        $image->update(['status' => MediaImage::STATUS_READY, 'processing_error' => null]);
    }

    public function failed(\Throwable $exception): void
    {
        MediaImage::whereKey($this->mediaImageId)->update([
            'status' => MediaImage::STATUS_FAILED,
            'processing_error' => mb_substr($exception->getMessage(), 0, 65535),
        ]);
        Log::error('property_media.processing_failed', ['media_image_id' => $this->mediaImageId, 'error' => $exception->getMessage()]);
    }
}
