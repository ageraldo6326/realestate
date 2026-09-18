<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Throwable;

class PropertyCardThumbnailService
{
    private const DIRECTORY = 'img/cache/property-cards';

    /**
     * Returns the generated card thumbnail when it already exists.
     *
     * The public page deliberately never generates images during a request: that
     * work belongs to the upload flow and the Artisan backfill command.
     */
    public function urlFor(?string $source, ?int $width = 480): ?string
    {
        $thumbnail = $this->thumbnailPaths($source, $width);

        if ($thumbnail === null || !is_file($thumbnail['absolute'])) {
            return null;
        }

        return asset($thumbnail['relative']);
    }

    /**
     * Creates a WebP derivative without modifying the original image.
     */
    public function create(?string $source, ?int $width = 480): ?string
    {
        $thumbnail = $this->thumbnailPaths($source, $width);

        if ($thumbnail === null) {
            return null;
        }

        if (!is_file($thumbnail['absolute'])) {
            try {
                File::ensureDirectoryExists(dirname($thumbnail['absolute']), 0755, true);

                Image::make($thumbnail['source'])
                    ->orientate()
                    ->resize($thumbnail['width'], null, function ($constraint): void {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', 75)
                    ->save($thumbnail['absolute']);
            } catch (Throwable $exception) {
                report($exception);

                return null;
            }
        }

        return asset($thumbnail['relative']);
    }

    /**
     * @return array{source: string, relative: string, absolute: string, width: int}|null
     */
    private function thumbnailPaths(?string $source, ?int $width): ?array
    {
        $relativeSource = $this->relativeSourcePath($source);
        $width = max(64, min((int) $width, 1600));

        if ($relativeSource === null) {
            return null;
        }

        $absoluteSource = public_path($relativeSource);

        if (!is_file($absoluteSource) || !@getimagesize($absoluteSource)) {
            return null;
        }

        $fingerprint = sha1($relativeSource . '|' . (string) filemtime($absoluteSource) . '|' . $width);
        $relativeThumbnail = self::DIRECTORY . '/' . $fingerprint . '.webp';

        return [
            'source' => $absoluteSource,
            'relative' => $relativeThumbnail,
            'absolute' => public_path($relativeThumbnail),
            'width' => $width,
        ];
    }

    private function relativeSourcePath(?string $source): ?string
    {
        $source = trim((string) $source);

        if ($source === '' || Str::startsWith($source, ['http://', 'https://', '//', 'data:'])) {
            return null;
        }

        $relative = Str::startsWith($source, ['/img/', '/assets/', '/storage/', 'img/', 'assets/', 'storage/'])
            ? ltrim($source, '/')
            : 'assets/' . ltrim($source, '/');
        $relative = str_replace('\\', '/', $relative);

        if (str_contains($relative, '..')) {
            return null;
        }

        return $relative;
    }
}
