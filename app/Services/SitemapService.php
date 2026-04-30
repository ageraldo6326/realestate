<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Propiedad;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SitemapService
{
    private const CACHE_KEY = 'seo.sitemap.xml';
    private const CACHE_TTL_MINUTES = 30;

    public function getXml(): string
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(self::CACHE_TTL_MINUTES), function (): string {
            $xml = $this->buildXml();
            $this->writePublicSitemap($xml);

            return $xml;
        });
    }

    public function refresh(): string
    {
        $xml = $this->buildXml();

        Cache::put(self::CACHE_KEY, $xml, now()->addMinutes(self::CACHE_TTL_MINUTES));
        $this->writePublicSitemap($xml);

        return $xml;
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function buildXml(): string
    {
        $inmobiliaria = InmobiliariaService::get();

        if (!$inmobiliaria || empty($inmobiliaria->dominio)) {
            return $this->renderXml([]);
        }

        $baseUrl = $this->normalizeBaseUrl((string) $inmobiliaria->dominio);
        $defaultLastmod = $this->toW3cDate($inmobiliaria->updated_at ?? now());

        $entries = [];

        $this->addEntry($entries, $baseUrl, $defaultLastmod, 1.0);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'propiedades'), $defaultLastmod, 0.9);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'blog'), $defaultLastmod, 0.8);
        $this->addEntry($entries, $this->joinUrl($baseUrl, 'contacto'), $defaultLastmod, 0.7);

        Propiedad::query()
            ->where('activa', 1)
            ->whereNotNull('slug')
            ->select('id', 'slug', 'updated_at')
            ->orderBy('id')
            ->chunkById(500, function ($propiedades) use (&$entries, $baseUrl): void {
                foreach ($propiedades as $propiedad) {
                    $this->addEntry(
                        $entries,
                        $this->joinUrl($baseUrl, 'propiedad/' . ltrim((string) $propiedad->slug, '/')),
                        $this->toW3cDate($propiedad->updated_at),
                        0.6
                    );
                }
            });

        foreach (CatalogoService::zonas() as $zona) {
            $slug = \Illuminate\Support\Str::slug((string) $zona->zona);

            if ($slug === '') {
                continue;
            }

            $this->addEntry(
                $entries,
                $this->joinUrl($baseUrl, $slug),
                $this->toW3cDate($zona->updated_at ?? null) ?? $defaultLastmod,
                0.7
            );
        }

        foreach (CatalogoService::tipos() as $tipo) {
            $slug = \Illuminate\Support\Str::slug((string) $tipo->tipo);

            if ($slug === '') {
                continue;
            }

            $this->addEntry(
                $entries,
                $this->joinUrl($baseUrl, 'venta/' . $slug),
                $this->toW3cDate($tipo->updated_at ?? null) ?? $defaultLastmod,
                0.7
            );
        }

        Post::query()
            ->whereNotNull('slug')
            ->select('id', 'slug', 'updated_at')
            ->orderByDesc('id')
            ->chunkById(500, function ($posts) use (&$entries, $baseUrl, $defaultLastmod): void {
                foreach ($posts as $post) {
                    $this->addEntry(
                        $entries,
                        $this->joinUrl($baseUrl, 'post/' . ltrim((string) $post->slug, '/')),
                        $this->toW3cDate($post->updated_at ?? null) ?? $defaultLastmod,
                        0.6
                    );
                }
            });

        return $this->renderXml(array_values($entries));
    }

    private function addEntry(array &$entries, string $loc, ?string $lastmod, float $priority): void
    {
        $key = rtrim($loc, '/');

        if ($key === '') {
            $key = $loc;
        }

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

            if (!empty($entry['priority'])) {
                $lines[] = '    <priority>' . $entry['priority'] . '</priority>';
            }

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
        if (!$value) {
            return null;
        }

        return Carbon::parse($value)->utc()->toAtomString();
    }

    private function normalizeBaseUrl(string $dominio): string
    {
        $trimmed = trim($dominio);

        if ($trimmed === '') {
            $trimmed = (string) config('app.url', '/');
        }

        return rtrim($trimmed, '/') . '/';
    }

    private function joinUrl(string $baseUrl, string $path): string
    {
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    private function writePublicSitemap(string $xml): void
    {
        $targetPath = public_path('sitemap.xml');
        $tmpPath = public_path('sitemap.xml.tmp');

        file_put_contents($tmpPath, $xml, LOCK_EX);
        @rename($tmpPath, $targetPath);

        if (file_exists($tmpPath)) {
            @copy($tmpPath, $targetPath);
            @unlink($tmpPath);
        }
    }
}
