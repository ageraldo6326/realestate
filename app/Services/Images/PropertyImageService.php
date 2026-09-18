<?php

namespace App\Services\Images;

use App\Jobs\ProcessPropertyMediaImage;
use App\Models\MediaImage;
use App\Models\Propiedad;
use Illuminate\Http\UploadedFile;

class PropertyImageService
{
    public function store(UploadedFile $file, Propiedad $property, string $slot, ?int $createdBy = null): MediaImage
    {
        return app(ImageUploadService::class)->store(
            $file,
            $this->profilesFor($slot)[0],
            $property,
            $createdBy,
            $property->titulo,
            $slot,
            false
        );
    }

    public function dispatch(MediaImage $image): void
    {
        ProcessPropertyMediaImage::dispatch($image->id)
            ->onQueue((string) config('images.queue'));
    }

    public function profilesFor(string $slot): array
    {
        return $slot === 'foto_portada'
            ? ['property_cover', 'home_card']
            : ['property_gallery', 'thumbnail'];
    }

    public function primaryProfile(string $slot): string
    {
        return $slot === 'foto_portada' ? 'property_cover' : 'property_gallery';
    }
}
