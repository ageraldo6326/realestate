<?php

namespace App\Services;

use Illuminate\Support\Str;

class SeoPublicVerificationService
{
    public function issues(): array
    {
        $company = InmobiliariaService::get();
        $canonical = InmobiliariaService::canonicalUrl($company);
        $issues = [];

        if (!InmobiliariaService::indexingEnabled($company)) {
            $issues[] = 'La indexación pública está desactivada (seo_indexable = false).';
        }

        if (!Str::startsWith($canonical, 'https://') || $this->isDevelopmentHost($canonical)) {
            $issues[] = 'El dominio canónico debe usar HTTPS y no puede ser local.';
        }

        $xml = app(SitemapService::class)->refresh();
        if (!Str::contains($xml, '<urlset')) {
            $issues[] = 'El sitemap dinámico no contiene un documento XML válido.';
        }
        if (Str::contains(strtolower($xml), ['.local', 'localhost', '127.0.0.1'])) {
            $issues[] = 'El sitemap contiene URLs de desarrollo o locales.';
        }

        return $issues;
    }

    private function isDevelopmentHost(string $url): bool
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        return $host === '' || Str::contains($host, ['.local', 'localhost', '127.0.0.1']);
    }
}
