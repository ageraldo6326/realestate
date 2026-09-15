<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Propiedad;
use App\Models\SitemapVersion;
use App\Models\TiposDePropiedad;
use App\Models\Zonas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SitemapService
{
    private const CACHE_KEY = 'seo.sitemap.xml';
    private const CACHE_TTL_MINUTES = 30;

    public function getXml(): string
    {
        return Cache::remember(
            self::CACHE_KEY,
            now()->addMinutes(self::CACHE_TTL_MINUTES),
            fn (): string => $this->buildXml()
        );
    }

    public function refresh(): string
    {
        $xml = $this->buildXml();
        Cache::put(self::CACHE_KEY, $xml, now()->addMinutes(self::CACHE_TTL_MINUTES));

        return $xml;
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function buildXml(): string
    {
        $company = InmobiliariaService::get();
        $baseUrl = $this->normalizeBaseUrl(InmobiliariaService::canonicalUrl($company));
        $defaultLastmod = $this->toW3cDate(optional($company)->updated_at ?? now());
        $entries = [];

        $this->addEntry($entries, $baseUrl, $defaultLastmod, 1.0);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'propiedades'), $defaultLastmod, 0.9);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'blog'), $defaultLastmod, 0.8);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'contacto'), $defaultLastmod, 0.7);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'quienessomos'), $defaultLastmod, 0.6);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'equipo'), $defaultLastmod, 0.6);

        Propiedad::query()
            ->publiclyVisible()
            ->select('id', 'slug', 'updated_at')
            ->orderBy('id')
            ->chunkById(500, function ($properties) use (&$entries, $baseUrl): void {
                foreach ($properties as $property) {
                    $this->addEntry(
                        $entries,
                        $this->joinUrl($baseUrl, 'propiedades/' . ltrim((string) $property->slug, '/')),
                        $this->toW3cDate($property->updated_at),
                        0.8
                    );
                }
            });

        Zonas::query()
            ->where('is_public', true)
            ->whereNotNull('slug')
            ->where('slug', '<>', '')
            ->where(function ($query): void {
                $query->where(function ($editorial): void {
                    $editorial->whereNotNull('seo_description')->where('seo_description', '<>', '');
                })
                    ->orWhereHas('propiedades', function ($properties): void {
                        $properties->publiclyVisible();
                    });
            })
            ->select('id', 'slug', 'updated_at')
            ->orderBy('id')
            ->chunkById(500, function ($zones) use (&$entries, $baseUrl, $defaultLastmod): void {
                foreach ($zones as $zone) {
                    $this->addEntry(
                        $entries,
                        $this->joinUrl($baseUrl, 'propiedades/zona/' . ltrim((string) $zone->slug, '/')),
                        $this->toW3cDate($zone->updated_at) ?? $defaultLastmod,
                        0.7
                    );
                }
            });

        TiposDePropiedad::query()
            ->whereHas('propiedades', function ($properties): void {
                $properties->publiclyVisible();
            })
            ->select('id', 'tipo', 'updated_at')
            ->orderBy('id')
            ->chunkById(500, function ($types) use (&$entries, $baseUrl, $defaultLastmod): void {
                foreach ($types as $type) {
                    $slug = Str::slug((string) $type->tipo);
                    if ($slug === '') {
                        continue;
                    }

                    $this->addEntry(
                        $entries,
                        $this->joinUrl($baseUrl, 'venta/' . $slug),
                        $this->toW3cDate($type->updated_at) ?? $defaultLastmod,
                        0.7
                    );
                }
            });

        Post::query()
            ->published()
            ->whereNotNull('slug')
            ->where('slug', '<>', '')
            ->select('id', 'slug', 'updated_at')
            ->orderBy('id')
            ->chunkById(500, function ($posts) use (&$entries, $baseUrl, $defaultLastmod): void {
                foreach ($posts as $post) {
                    $this->addEntry(
                        $entries,
                        $this->joinUrl($baseUrl, 'blog/' . ltrim((string) $post->slug, '/')),
                        $this->toW3cDate($post->updated_at) ?? $defaultLastmod,
                        0.7
                    );
                }
            });

        $xml = $this->renderXml(array_values($entries));
        $this->recordVersion($company, $baseUrl, $xml, count($entries));

        return $xml;
    }

    private function addEntry(array &$entries, string $loc, ?string $lastmod, float $priority): void
    {
        $key = rtrim($loc, '/') ?: $loc;

        if (isset($entries[$key])) {
            if ($lastmod && (!isset($entries[$key]['lastmod']) || $lastmod > $entries[$key]['lastmod'])) {
                $entries[$key]['lastmod'] = $lastmod;
            }
            return;
        }

        $entries[$key] = [
            'loc' => $loc,
            'lastmod' => $lastmod,
            'priority' => number_format($priority, 1, '.', ''),
        ];
    }

    private function renderXml(array $entries): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($entries as $entry) {
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . $this->escapeXml((string) $entry['loc']) . '</loc>';
            if (!empty($entry['lastmod'])) {
                $lines[] = '    <lastmod>' . $this->escapeXml((string) $entry['lastmod']) . '</lastmod>';
            }
            $lines[] = '    <priority>' . $entry['priority'] . '</priority>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }

    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    }

    private function toW3cDate($value): ?string
    {
        return $value ? Carbon::parse($value)->utc()->toAtomString() : null;
    }

    private function normalizeBaseUrl(string $url): string
    {
        return rtrim(trim($url), '/') . '/';
    }

    private function joinUrl(string $baseUrl, string $path): string
    {
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    private function recordVersion($company, string $baseUrl, string $xml, int $urlCount): void
    {
        if (!Schema::hasTable('sitemap_versions')) {
            return;
        }

        $checksum = hash('sha256', $xml);
        $latest = SitemapVersion::query()
            ->where('inmobiliaria_id', optional($company)->id)
            ->latest('id')
            ->first();

        if ($latest && $latest->checksum === $checksum) {
            return;
        }

        SitemapVersion::query()->create([
            'inmobiliaria_id' => optional($company)->id,
            'canonical_host' => (string) parse_url($baseUrl, PHP_URL_HOST),
            'checksum' => $checksum,
            'url_count' => $urlCount,
            'status' => 'generated',
            'generated_at' => now(),
        ]);
    }
}
