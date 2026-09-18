<?php

namespace App\Services\Images;

use InvalidArgumentException;

class ImageProfile
{
    public static function get(string $profile): array
    {
        $profiles = self::all();

        if (! isset($profiles[$profile])) {
            throw new InvalidArgumentException("El perfil de imagen [{$profile}] no existe.");
        }

        return $profiles[$profile];
    }

    public static function all(): array
    {
        return [
            'home_hero' => ['widths' => [640, 960, 1280, 1600, 1920], 'crop' => true, 'ratio' => [16, 9]],
            'home_card' => ['widths' => [320, 480, 640, 960], 'crop' => true, 'ratio' => [4, 3]],
            'property_cover' => ['widths' => [640, 960, 1280, 1600], 'crop' => false, 'ratio' => null],
            'property_gallery' => ['widths' => [480, 800, 1200, 1600], 'crop' => false, 'ratio' => null],
            'thumbnail' => ['widths' => [160, 240, 320], 'crop' => true, 'ratio' => [4, 3]],
            'avatar' => ['widths' => [96, 160, 256], 'crop' => true, 'ratio' => [1, 1]],
            'brand_logo' => ['widths' => [96, 144, 192, 288], 'crop' => false, 'ratio' => null],
            'content_banner' => ['widths' => [640, 960, 1280, 1600], 'crop' => true, 'ratio' => [16, 9]],
        ];
    }
}
