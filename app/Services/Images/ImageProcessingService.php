<?php

namespace App\Services\Images;

use App\Models\MediaImage;
use App\Models\MediaImageVariant;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RuntimeException;

class ImageProcessingService
{
    public function process(MediaImage $mediaImage, string $profileName): void
    {
        $profile = ImageProfile::get($profileName);
        $source = Storage::disk($mediaImage->disk)->path($mediaImage->original_path);

        if (! is_file($source)) {
            throw new RuntimeException('El original privado no está disponible para procesar la imagen.');
        }

        foreach ($profile['widths'] as $targetWidth) {
            if ($targetWidth > $mediaImage->original_width) {
                continue;
            }

            $image = Image::make($source)->orientate();
            if ($profile['crop']) {
                [$ratioWidth, $ratioHeight] = $profile['ratio'];
                $image->fit($targetWidth, (int) round($targetWidth * $ratioHeight / $ratioWidth), function ($constraint): void {
                    $constraint->upsize();
                });
            } else {
                $image->resize($targetWidth, null, function ($constraint): void {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            foreach ($this->enabledFormats() as $format => $quality) {
                $encoded = (string) (clone $image)->encode($format, $quality);
                $path = $this->pathFor($mediaImage, $profileName, $image->width(), $format);
                $disk = (string) config('images.delivery_disk');

                Storage::disk($disk)->put($path, $encoded, 'public');

                MediaImageVariant::updateOrCreate(
                    [
                        'media_image_id' => $mediaImage->id,
                        'profile' => $profileName,
                        'format' => $format,
                        'width' => $image->width(),
                    ],
                    [
                        'disk' => $disk,
                        'height' => $image->height(),
                        'bytes' => strlen($encoded),
                        'path' => $path,
                        'checksum' => hash('sha256', $encoded),
                    ]
                );
            }
        }
    }

    private function enabledFormats(): array
    {
        $formats = [];

        foreach ((array) config('images.formats') as $format => $settings) {
            if (! ($settings['enabled'] ?? false)) {
                continue;
            }

            if ($format === 'webp' && ! function_exists('imagewebp')) {
                continue;
            }

            if ($format === 'avif' && ! function_exists('imageavif')) {
                continue;
            }

            $formats[$format] = (int) $settings['quality'];
        }

        return $formats;
    }

    private function pathFor(MediaImage $mediaImage, string $profile, int $width, string $format): string
    {
        return sprintf(
            'media/images/%d/%s/%s/%dw.%s',
            $mediaImage->id,
            $mediaImage->checksum,
            $profile,
            $width,
            $format
        );
    }
}
