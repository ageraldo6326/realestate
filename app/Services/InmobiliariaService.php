<?php

namespace App\Services;

use App\Models\Inmobiliaria;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class InmobiliariaService
{
    public static function get(): ?Inmobiliaria
    {
        if (!Schema::hasTable('inmobiliarias')) {
            return null;
        }

        return Cache::remember('inmobiliaria.config', now()->addMinutes(60), function () {
            return Inmobiliaria::query()->first();
        });
    }

    public static function forget(): void
    {
        Cache::forget('inmobiliaria.config');
    }

    public static function canonicalUrl(?object $company = null): string
    {
        $configuredUrl = trim((string) ($company?->seo_canonical_url ?? ''));
        $fallbackUrl = trim((string) config('seo.canonical_url', config('app.url')));
        $url = $configuredUrl !== '' ? $configuredUrl : $fallbackUrl;

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $url = $fallbackUrl;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        if ($host === '') {
            return rtrim($fallbackUrl, '/');
        }

        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
        $port = parse_url($url, PHP_URL_PORT);
        $authority = $host . ($port ? ':' . $port : '');
        $normalizedScheme = $scheme === 'http' && app()->environment('local', 'testing') ? 'http' : 'https';

        return $normalizedScheme . '://' . $authority . ($path === '' ? '' : '/' . $path);
    }

    public static function indexingEnabled(?object $company = null): bool
    {
        if ($company instanceof Inmobiliaria && $company->getAttribute('seo_indexable') !== null) {
            return (bool) $company->seo_indexable;
        }

        if ($company !== null && property_exists($company, 'seo_indexable') && $company->seo_indexable !== null) {
            return (bool) $company->seo_indexable;
        }

        return (bool) config('seo.indexing_enabled');
    }

    public static function searchConsoleVerificationToken(?object $company = null): ?string
    {
        $token = trim((string) $company?->search_console_verification_token);

        return $token === '' ? null : $token;
    }

    public static function publicHosts(?object $company = null): array
    {
        $canonicalHost = strtolower((string) parse_url(self::canonicalUrl($company), PHP_URL_HOST));
        $alternateHosts = is_array($company?->seo_alternate_hosts) ? $company->seo_alternate_hosts : [];
        $hosts = array_merge([$canonicalHost], $alternateHosts);

        return array_values(array_unique(array_filter(array_map(static function ($host): string {
            return strtolower(trim(preg_replace('#^https?://#i', '', (string) $host), '/'));
        }, $hosts))));
    }
}
