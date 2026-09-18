<?php

namespace App\Listeners;

use App\Events\PropertySaved;
use App\Models\MediaImage;
use App\Services\Images\PropertyImageService;

class ProcessPendingPropertyMediaImages
{
    public function handle(PropertySaved $event): void
    {
        $event->propiedad->images()
            ->where('status', MediaImage::STATUS_PENDING)
            ->get()
            ->each(fn (MediaImage $image) => app(PropertyImageService::class)->dispatch($image));
    }
}
