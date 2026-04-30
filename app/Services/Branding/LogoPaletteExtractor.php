<?php

namespace App\Services\Branding;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Intervention\Image\Facades\Image as ImageFacade;

class LogoPaletteExtractor
{
    public function extractFromUploadedFile(UploadedFile $file): array
    {
        return $this->extractFromImage(ImageFacade::make($file)->orientate());
    }

    public function extractFromPath(string $path): array
    {
        return $this->extractFromImage(ImageFacade::make($path)->orientate());
    }

    private function extractFromImage(Image $image): array
    {
        $image->resize(120, 120, function ($constraint): void {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $width = max(1, (int) $image->width());
        $height = max(1, (int) $image->height());
        $step = max(1, (int) floor(sqrt(($width * $height) / 1600)));

        $swatches = [];

        for ($y = 0; $y < $height; $y += $step) {
            for ($x = 0; $x < $width; $x += $step) {
                $rgba = $image->pickColor($x, $y, 'array');
                $opacity = $this->normalizeOpacity($rgba[3] ?? null);

                if ($opacity < 40) {
                    continue;
                }

                $rgb = [
                    (int) ($rgba[0] ?? 0),
                    (int) ($rgba[1] ?? 0),
                    (int) ($rgba[2] ?? 0),
                ];

                if ($this->shouldIgnore($rgb)) {
                    continue;
                }

                $quantized = $this->quantize($rgb);
                $hex = $this->rgbToHex($quantized);
                $saturation = $this->saturation($quantized);
                $swatches[$hex] = ($swatches[$hex] ?? 0) + max(1, (int) round(1 + ($saturation * 4)));
            }
        }

        arsort($swatches);

        $palette = [];

        foreach (array_keys($swatches) as $hex) {
            if ($this->isDistinctEnough($hex, $palette)) {
                $palette[] = $hex;
            }

            if (count($palette) === 4) {
                break;
            }
        }

        return $palette;
    }

    private function normalizeOpacity($alpha): int
    {
        if ($alpha === null || !is_numeric($alpha)) {
            return 255;
        }

        $value = (float) $alpha;

        // Some drivers return alpha as 0..1 (0 transparent, 1 opaque).
        if ($value >= 0 && $value <= 1) {
            return (int) round($value * 255);
        }

        // GD commonly returns 0..127 (0 opaque, 127 transparent).
        if ($value >= 0 && $value <= 127) {
            return (int) round((1 - ($value / 127)) * 255);
        }

        // Treat 0..255 values as direct opacity.
        return (int) max(0, min(255, round($value)));
    }

    private function shouldIgnore(array $rgb): bool
    {
        $max = max($rgb);
        $min = min($rgb);
        $luminance = $this->luminance($rgb);
        $saturation = $this->saturation($rgb);

        if ($luminance >= 245 && $saturation <= 0.12) {
            return true;
        }

        if ($luminance <= 18 && $saturation <= 0.18) {
            return true;
        }

        return ($max - $min) <= 8 && ($luminance <= 35 || $luminance >= 235);
    }

    private function quantize(array $rgb): array
    {
        return array_map(function (int $channel): int {
            $value = (int) round($channel / 24) * 24;

            return max(0, min(255, $value));
        }, $rgb);
    }

    private function isDistinctEnough(string $hex, array $palette): bool
    {
        foreach ($palette as $existingHex) {
            if ($this->colorDistance($hex, $existingHex) < 48) {
                return false;
            }
        }

        return true;
    }

    private function colorDistance(string $firstHex, string $secondHex): float
    {
        $first = $this->hexToRgb($firstHex);
        $second = $this->hexToRgb($secondHex);

        return sqrt(
            (($first[0] - $second[0]) ** 2) +
                (($first[1] - $second[1]) ** 2) +
                (($first[2] - $second[2]) ** 2)
        );
    }

    private function luminance(array $rgb): float
    {
        return (0.299 * $rgb[0]) + (0.587 * $rgb[1]) + (0.114 * $rgb[2]);
    }

    private function saturation(array $rgb): float
    {
        $red = $rgb[0] / 255;
        $green = $rgb[1] / 255;
        $blue = $rgb[2] / 255;

        $max = max($red, $green, $blue);
        $min = min($red, $green, $blue);

        if ($max === $min) {
            return 0.0;
        }

        $lightness = ($max + $min) / 2;

        return $lightness > 0.5
            ? ($max - $min) / (2 - $max - $min)
            : ($max - $min) / ($max + $min);
    }

    private function rgbToHex(array $rgb): string
    {
        return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
    }

    private function hexToRgb(string $hex): array
    {
        $hex = ltrim(strtolower($hex), '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}
