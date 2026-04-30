<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ContentMediaService
{
    public function storeImageAsWebp(UploadedFile $file, string $directory, ?int $width = null, ?int $height = null): string
    {
        $relativeDirectory = trim($directory, '/');
        $absoluteDirectory = public_path('img/' . $relativeDirectory);

        if (!is_dir($absoluteDirectory)) {
            mkdir($absoluteDirectory, 0755, true);
        }

        $filename = (string) Str::uuid() . '.webp';
        $absolutePath = $absoluteDirectory . DIRECTORY_SEPARATOR . $filename;

        $image = Image::make($file)->orientate();

        if ($width !== null && $height !== null) {
            $image->fit($width, $height, function ($constraint): void {
                $constraint->upsize();
            });
        }

        $image->encode('webp', 90)->save($absolutePath);

        return '/img/' . $relativeDirectory . '/' . $filename;
    }

    public function extractYoutubeVideoId(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (preg_match('~(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/)([A-Za-z0-9_-]{6,})~', $value, $matches) === 1) {
            return $matches[1] ?? null;
        }

        if (preg_match('~^[A-Za-z0-9_-]{6,}$~', $value) === 1) {
            return $value;
        }

        return null;
    }
}
