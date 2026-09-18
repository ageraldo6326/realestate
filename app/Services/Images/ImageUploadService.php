<?php

namespace App\Services\Images;

use App\Jobs\ProcessMediaImage;
use App\Models\MediaImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageUploadService
{
    public function store(UploadedFile $file, string $profile, ?Model $imageable = null, ?int $createdBy = null, ?string $altText = null): MediaImage
    {
        ImageProfile::get($profile);
        $details = $this->validate($file);
        $disk = (string) config('images.original_disk');
        $extension = $this->extensionForMime($details['mime']);
        $path = 'media/originals/' . Str::uuid() . '.' . $extension;

        Storage::disk($disk)->putFileAs(dirname($path), $file, basename($path));

        try {
            $mediaImage = DB::transaction(function () use ($details, $disk, $path, $imageable, $createdBy, $altText): MediaImage {
                $attributes = [
                    'disk' => $disk,
                    'original_path' => $path,
                    'original_mime_type' => $details['mime'],
                    'original_width' => $details['width'],
                    'original_height' => $details['height'],
                    'original_bytes' => $details['bytes'],
                    'checksum' => $details['checksum'],
                    'alt_text' => $altText,
                    'status' => MediaImage::STATUS_PENDING,
                    'created_by' => $createdBy,
                ];

                return $imageable === null
                    ? MediaImage::create($attributes)
                    : $imageable->images()->create($attributes);
            });
        } catch (\Throwable $exception) {
            Storage::disk($disk)->delete($path);

            throw $exception;
        }

        ProcessMediaImage::dispatch($mediaImage->id, $profile)
            ->onQueue((string) config('images.queue'))
            ->afterCommit();

        return $mediaImage;
    }

    private function validate(UploadedFile $file): array
    {
        $path = $file->getRealPath();
        $image = $path === false ? false : @getimagesize($path);
        $mime = $path === false ? false : @mime_content_type($path);
        $bytes = $file->getSize() ?: 0;

        if ($image === false || $mime === false || ! in_array($mime, config('images.accepted_mime_types'), true)) {
            throw ValidationException::withMessages(['image' => 'El archivo debe ser una imagen JPG, PNG o WebP válida.']);
        }

        [$width, $height] = $image;
        $maxBytes = (int) config('images.max_upload_bytes');
        $maxWidth = (int) config('images.max_width');
        $maxHeight = (int) config('images.max_height');
        $maxPixels = (int) config('images.max_pixels');

        if ($bytes > $maxBytes || $width > $maxWidth || $height > $maxHeight || ($width * $height) > $maxPixels) {
            throw ValidationException::withMessages(['image' => 'La imagen excede los límites permitidos de tamaño o resolución.']);
        }

        return [
            'mime' => $mime,
            'width' => $width,
            'height' => $height,
            'bytes' => $bytes,
            'checksum' => hash_file('sha256', $path),
        ];
    }

    private function extensionForMime(string $mime): string
    {
        return [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ][$mime];
    }
}
