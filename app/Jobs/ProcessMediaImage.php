<?php

namespace App\Jobs;

use App\Models\MediaImage;
use App\Services\Images\ImageProcessingService;
use App\Services\Images\ImageProfile;
use App\Services\Images\MediaImagePublicationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessMediaImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = [60, 120, 300];

    public function __construct(private int $mediaImageId, private ?string $profile = null)
    {
    }

    public function handle(ImageProcessingService $processor, MediaImagePublicationService $publisher): void
    {
        $mediaImage = MediaImage::find($this->mediaImageId);

        if ($mediaImage === null) {
            return;
        }

        $mediaImage->update([
            'status' => MediaImage::STATUS_PROCESSING,
            'processing_error' => null,
        ]);

        $profiles = $this->profile === null ? array_keys(ImageProfile::all()) : [$this->profile];
        foreach ($profiles as $profile) {
            $processor->process($mediaImage, $profile);
            $publisher->publishWebp($mediaImage, $profile);
        }

        $mediaImage->update(['status' => MediaImage::STATUS_READY]);
    }

    public function failed(\Throwable $exception): void
    {
        MediaImage::whereKey($this->mediaImageId)->update([
            'status' => MediaImage::STATUS_FAILED,
            'processing_error' => mb_substr($exception->getMessage(), 0, 65535),
        ]);

        Log::error('media_image.processing_failed', [
            'media_image_id' => $this->mediaImageId,
            'profile' => $this->profile,
            'error' => $exception->getMessage(),
        ]);
    }
}
