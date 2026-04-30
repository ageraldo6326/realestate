<?php

namespace App\Services\Branding;

use App\Models\Inmobiliaria;

class CompanyBrandingService
{
    public const SOURCE_DEFAULT = 'default';
    public const SOURCE_LOGO = 'logo';
    public const SOURCE_MANUAL = 'manual';

    public function getDefaultTheme(): array
    {
        return [
            'theme_color_primary' => '#1c1c2e',
            'theme_color_secondary' => '#2d2d3f',
            'theme_color_accent' => '#c9a84c',
            'theme_color_neutral' => '#6b7280',
            'theme_source' => self::SOURCE_DEFAULT,
        ];
    }

    public function getDefaultCssVariables(): array
    {
        return [
            '--clr-accent' => '#c9a84c',
            '--clr-accent-dk' => '#b8943e',
            '--clr-accent-lt' => '#e8d49e',
            '--clr-accent-rgb' => '201, 168, 76',
            '--clr-dark' => '#1c1c2e',
            '--clr-dark-2' => '#2d2d3f',
            '--clr-dark-rgb' => '28, 28, 46',
            '--clr-gray' => '#6b7280',
            '--clr-gray-lt' => '#9ca3af',
            '--clr-bg' => '#f9f8f6',
            '--clr-white' => '#ffffff',
            '--clr-border' => '#e5e7eb',
        ];
    }

    public function resolveTheme(?Inmobiliaria $company): array
    {
        $defaultTheme = $this->getDefaultTheme();

        if (!$company) {
            return $defaultTheme;
        }

        return [
            'theme_color_primary' => $this->normalizeHex($company->theme_color_primary) ?? $defaultTheme['theme_color_primary'],
            'theme_color_secondary' => $this->normalizeHex($company->theme_color_secondary) ?? $defaultTheme['theme_color_secondary'],
            'theme_color_accent' => $this->normalizeHex($company->theme_color_accent) ?? $defaultTheme['theme_color_accent'],
            'theme_color_neutral' => $this->normalizeHex($company->theme_color_neutral) ?? $defaultTheme['theme_color_neutral'],
            'theme_source' => in_array($company->theme_source, [self::SOURCE_DEFAULT, self::SOURCE_LOGO, self::SOURCE_MANUAL], true)
                ? $company->theme_source
                : $defaultTheme['theme_source'],
        ];
    }

    public function resolvePreviousTheme(?Inmobiliaria $company): ?array
    {
        if (!$company) {
            return null;
        }

        $primary = $this->normalizeHex($company->previous_theme_color_primary);
        $secondary = $this->normalizeHex($company->previous_theme_color_secondary);
        $accent = $this->normalizeHex($company->previous_theme_color_accent);
        $neutral = $this->normalizeHex($company->previous_theme_color_neutral);

        if (!$primary || !$secondary || !$accent || !$neutral) {
            return null;
        }

        return [
            'theme_color_primary' => $primary,
            'theme_color_secondary' => $secondary,
            'theme_color_accent' => $accent,
            'theme_color_neutral' => $neutral,
            'theme_source' => $company->previous_theme_source ?: self::SOURCE_MANUAL,
        ];
    }

    public function hasPreviousTheme(?Inmobiliaria $company): bool
    {
        return $this->resolvePreviousTheme($company) !== null;
    }

    public function resolveLogoPalette(?Inmobiliaria $company): array
    {
        if (!$company) {
            return [];
        }

        return array_values(array_filter([
            $this->normalizeHex($company->logo_color_1),
            $this->normalizeHex($company->logo_color_2),
            $this->normalizeHex($company->logo_color_3),
            $this->normalizeHex($company->logo_color_4),
        ]));
    }

    public function storeLogoPalette(Inmobiliaria $company, array $palette): void
    {
        $palette = array_values(array_slice(array_filter(array_map([$this, 'normalizeHex'], $palette)), 0, 4));

        $company->logo_color_1 = $palette[0] ?? null;
        $company->logo_color_2 = $palette[1] ?? null;
        $company->logo_color_3 = $palette[2] ?? null;
        $company->logo_color_4 = $palette[3] ?? null;
    }

    public function buildThemeFromPalette(array $palette): array
    {
        $palette = array_values(array_unique(array_filter(array_map([$this, 'normalizeHex'], $palette))));

        if ($palette === []) {
            return $this->getDefaultTheme();
        }

        $sortedByLuminance = $palette;
        usort($sortedByLuminance, function (string $left, string $right): int {
            return $this->luminance($left) <=> $this->luminance($right);
        });

        $sortedBySaturation = $palette;
        usort($sortedBySaturation, function (string $left, string $right): int {
            return $this->saturation($right) <=> $this->saturation($left);
        });

        $primary = $sortedByLuminance[0] ?? $this->getDefaultTheme()['theme_color_primary'];
        $secondary = $sortedByLuminance[1] ?? $this->mixWithWhite($primary, 0.18);
        $accent = $this->firstColorNotIn($sortedBySaturation, [$primary, $secondary]) ?? ($sortedBySaturation[0] ?? $this->getDefaultTheme()['theme_color_accent']);
        $neutral = $this->pickNeutral($palette, [$primary, $secondary, $accent]) ?? $this->getDefaultTheme()['theme_color_neutral'];

        return [
            'theme_color_primary' => $primary,
            'theme_color_secondary' => $secondary,
            'theme_color_accent' => $accent,
            'theme_color_neutral' => $neutral,
            'theme_source' => self::SOURCE_LOGO,
        ];
    }

    public function getManualThemeInput(array $input): ?array
    {
        $theme = [
            'theme_color_primary' => $this->normalizeHex($input['theme_color_primary'] ?? null),
            'theme_color_secondary' => $this->normalizeHex($input['theme_color_secondary'] ?? null),
            'theme_color_accent' => $this->normalizeHex($input['theme_color_accent'] ?? null),
            'theme_color_neutral' => $this->normalizeHex($input['theme_color_neutral'] ?? null),
        ];

        return in_array(null, $theme, true) ? null : $theme;
    }

    public function themeDiffers(array $firstTheme, array $secondTheme): bool
    {
        foreach (['theme_color_primary', 'theme_color_secondary', 'theme_color_accent', 'theme_color_neutral'] as $key) {
            if (($this->normalizeHex($firstTheme[$key] ?? null) ?? '') !== ($this->normalizeHex($secondTheme[$key] ?? null) ?? '')) {
                return true;
            }
        }

        return false;
    }

    public function ensureThemeInitialized(Inmobiliaria $company): void
    {
        if ($company->theme_source && $company->theme_color_primary && $company->theme_color_secondary && $company->theme_color_accent && $company->theme_color_neutral) {
            return;
        }

        $defaultTheme = $this->getDefaultTheme();

        $company->theme_color_primary = $this->normalizeHex($company->theme_color_primary) ?? $defaultTheme['theme_color_primary'];
        $company->theme_color_secondary = $this->normalizeHex($company->theme_color_secondary) ?? $defaultTheme['theme_color_secondary'];
        $company->theme_color_accent = $this->normalizeHex($company->theme_color_accent) ?? $defaultTheme['theme_color_accent'];
        $company->theme_color_neutral = $this->normalizeHex($company->theme_color_neutral) ?? $defaultTheme['theme_color_neutral'];
        $company->theme_source = $company->theme_source ?: self::SOURCE_DEFAULT;
    }

    public function applyTheme(Inmobiliaria $company, array $theme, string $source): void
    {
        $this->ensureThemeInitialized($company);
        $this->snapshotCurrentTheme($company);

        $company->theme_color_primary = $this->normalizeHex($theme['theme_color_primary'] ?? null) ?? $this->getDefaultTheme()['theme_color_primary'];
        $company->theme_color_secondary = $this->normalizeHex($theme['theme_color_secondary'] ?? null) ?? $this->getDefaultTheme()['theme_color_secondary'];
        $company->theme_color_accent = $this->normalizeHex($theme['theme_color_accent'] ?? null) ?? $this->getDefaultTheme()['theme_color_accent'];
        $company->theme_color_neutral = $this->normalizeHex($theme['theme_color_neutral'] ?? null) ?? $this->getDefaultTheme()['theme_color_neutral'];
        $company->theme_source = $source;
    }

    public function restoreDefaultTheme(Inmobiliaria $company): void
    {
        $this->applyTheme($company, $this->getDefaultTheme(), self::SOURCE_DEFAULT);
    }

    public function restorePreviousTheme(Inmobiliaria $company): bool
    {
        $previousTheme = $this->resolvePreviousTheme($company);

        if (!$previousTheme) {
            return false;
        }

        $this->applyTheme($company, $previousTheme, $previousTheme['theme_source'] ?? self::SOURCE_MANUAL);

        return true;
    }

    public function resolveCssVariables(?Inmobiliaria $company): array
    {
        $theme = $this->resolveTheme($company);
        $defaults = $this->getDefaultCssVariables();

        if (($theme['theme_source'] ?? self::SOURCE_DEFAULT) === self::SOURCE_DEFAULT && !$this->themeDiffers($theme, $this->getDefaultTheme())) {
            return $defaults;
        }

        $neutral = $theme['theme_color_neutral'];
        $accent = $theme['theme_color_accent'];

        return [
            '--clr-accent' => $accent,
            '--clr-accent-dk' => $this->mixWithBlack($accent, 0.10),
            '--clr-accent-lt' => $this->mixWithWhite($accent, 0.58),
            '--clr-accent-rgb' => $this->rgbString($accent),
            '--clr-dark' => $theme['theme_color_primary'],
            '--clr-dark-2' => $theme['theme_color_secondary'],
            '--clr-dark-rgb' => $this->rgbString($theme['theme_color_primary']),
            '--clr-gray' => $neutral,
            '--clr-gray-lt' => $this->mixWithWhite($neutral, 0.35),
            '--clr-bg' => $this->mixWithWhite($neutral, 0.90),
            '--clr-white' => '#ffffff',
            '--clr-border' => $this->mixWithWhite($neutral, 0.78),
        ];
    }

    public function getSourceLabel(?string $source): string
    {
        switch ($source) {
            case self::SOURCE_LOGO:
                return 'Paleta del logo';
            case self::SOURCE_MANUAL:
                return 'Personalizacion manual';
            default:
                return 'Default del sistema';
        }
    }

    private function snapshotCurrentTheme(Inmobiliaria $company): void
    {
        $currentTheme = $this->resolveTheme($company);

        $company->previous_theme_color_primary = $currentTheme['theme_color_primary'];
        $company->previous_theme_color_secondary = $currentTheme['theme_color_secondary'];
        $company->previous_theme_color_accent = $currentTheme['theme_color_accent'];
        $company->previous_theme_color_neutral = $currentTheme['theme_color_neutral'];
        $company->previous_theme_source = $currentTheme['theme_source'];
    }

    private function firstColorNotIn(array $palette, array $excluded): ?string
    {
        foreach ($palette as $hex) {
            if (!in_array($hex, $excluded, true)) {
                return $hex;
            }
        }

        return null;
    }

    private function pickNeutral(array $palette, array $excluded): ?string
    {
        $candidates = array_values(array_filter($palette, function (string $hex) use ($excluded): bool {
            return !in_array($hex, $excluded, true);
        }));

        usort($candidates, function (string $left, string $right): int {
            return $this->saturation($left) <=> $this->saturation($right);
        });

        return $candidates[0] ?? null;
    }

    private function mixWithWhite(string $hex, float $ratio): string
    {
        $rgb = $this->hexToRgb($hex);
        $ratio = max(0, min(1, $ratio));

        $mixed = [
            (int) round($rgb[0] + ((255 - $rgb[0]) * $ratio)),
            (int) round($rgb[1] + ((255 - $rgb[1]) * $ratio)),
            (int) round($rgb[2] + ((255 - $rgb[2]) * $ratio)),
        ];

        return $this->rgbToHex($mixed);
    }

    private function mixWithBlack(string $hex, float $ratio): string
    {
        $rgb = $this->hexToRgb($hex);
        $ratio = max(0, min(1, $ratio));

        $mixed = [
            (int) round($rgb[0] * (1 - $ratio)),
            (int) round($rgb[1] * (1 - $ratio)),
            (int) round($rgb[2] * (1 - $ratio)),
        ];

        return $this->rgbToHex($mixed);
    }

    private function normalizeHex(?string $value): ?string
    {
        $value = strtolower(trim((string) $value));

        if ($value === '' || preg_match('/^#[0-9a-f]{6}$/', $value) !== 1) {
            return null;
        }

        return $value;
    }

    private function luminance(string $hex): float
    {
        $rgb = $this->hexToRgb($hex);

        return (0.299 * $rgb[0]) + (0.587 * $rgb[1]) + (0.114 * $rgb[2]);
    }

    private function saturation(string $hex): float
    {
        $rgb = $this->hexToRgb($hex);
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

    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    private function rgbToHex(array $rgb): string
    {
        return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
    }

    private function rgbString(string $hex): string
    {
        $rgb = $this->hexToRgb($hex);

        return implode(', ', $rgb);
    }
}
