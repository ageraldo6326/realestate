<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Propiedad;
use App\Models\Zonas;
use Illuminate\Support\Str;

class IndexabilityPolicy
{
    private StructuredDataService $structuredData;

    public function __construct(StructuredDataService $structuredData)
    {
        $this->structuredData = $structuredData;
    }

    public function evaluate(string $type, $entity = null): array
    {
        $canonical = app(CanonicalUrlService::class)->for($type, $entity);
        $findings = [];

        if (!InmobiliariaService::indexingEnabled(InmobiliariaService::get())) {
            $findings[] = $this->finding(
                'SEO-ROBOTS-001',
                'critical',
                'La indexación pública está desactivada; el sitio envía noindex y robots bloquea el rastreo.'
            );
        }

        if (!Str::startsWith($canonical, 'https://') || $this->isDevelopmentUrl($canonical)) {
            $findings[] = $this->finding(
                'SEO-DOMAIN-001',
                'critical',
                'El dominio canónico debe usar HTTPS y no puede apuntar a un entorno de desarrollo.',
                ['canonical_url' => $canonical]
            );
        }

        if ($type !== 'page' && !$this->hasValidSlug($entity->slug ?? null)) {
            $findings[] = $this->finding(
                'SEO-URL-005',
                'high',
                'El slug es inválido o no puede publicarse como URL canónica.',
                ['slug' => $entity->slug ?? null]
            );
        }

        if ($type === 'property') {
            $this->evaluateProperty($entity, $findings);
        }

        if ($type === 'zone') {
            $this->evaluateZone($entity, $findings);
        }

        if ($type === 'post') {
            $this->evaluatePost($entity, $findings);
        }

        $findings = array_merge($findings, $this->structuredData->findings(
            $type,
            $entity,
            InmobiliariaService::get()
        ));

        $hasBlockingFinding = collect($findings)->contains(static function (array $finding): bool {
            return in_array($finding['severity'], ['critical', 'high'], true);
        });
        $hasWarning = collect($findings)->isNotEmpty();

        return [
            'canonical_url' => $canonical,
            'is_indexable' => !$hasBlockingFinding,
            'status' => $hasBlockingFinding ? 'red' : ($hasWarning ? 'yellow' : 'green'),
            'score' => $this->score($findings),
            'findings' => $findings,
            'last_http_status' => $hasBlockingFinding ? 404 : 200,
            'lastmod_at' => $type === 'page' ? now() : ($entity->updated_at ?? now()),
        ];
    }

    private function evaluateProperty(Propiedad $property, array &$findings): void
    {
        if (!(bool) $property->activa || !(bool) $property->aprobada || (bool) $property->vendida) {
            $findings[] = $this->finding(
                'SEO-URL-002',
                'critical',
                'La propiedad no está pública, aprobada y disponible para indexación.'
            );
        }

        if (trim((string) $property->titulo) === '') {
            $findings[] = $this->finding('SEO-META-001', 'medium', 'La propiedad no tiene título público.');
        }

        if (trim((string) ($property->foto_portada ?? '')) === '') {
            $findings[] = $this->finding('SEO-IMAGE-001', 'low', 'La propiedad no tiene imagen principal.');
        }
    }

    private function evaluateZone(Zonas $zone, array &$findings): void
    {
        if (!(bool) $zone->is_public) {
            $findings[] = $this->finding('SEO-URL-002', 'critical', 'La zona no está marcada como pública.');

            return;
        }

        $hasEditorialContent = filled($zone->seo_description);
        $hasInventory = $zone->relationLoaded('propiedades')
            ? $zone->propiedades->contains(static function (Propiedad $property): bool {
                return (bool) $property->activa && (bool) $property->aprobada && !(bool) $property->vendida;
            })
            : $zone->propiedades()->publiclyVisible()->exists();

        if (!$hasEditorialContent && !$hasInventory) {
            $findings[] = $this->finding(
                'SEO-CONTENT-001',
                'high',
                'La zona no tiene inventario público ni contenido editorial suficiente.'
            );
        }

        if (trim((string) ($zone->seo_title ?: $zone->zona)) === '') {
            $findings[] = $this->finding('SEO-META-001', 'medium', 'La zona no tiene título SEO ni nombre visible.');
        }
    }

    private function evaluatePost(Post $post, array &$findings): void
    {
        if (!(bool) $post->activo || $post->status !== 'published' || ($post->published_at && $post->published_at->isFuture())) {
            $findings[] = $this->finding('SEO-URL-002', 'critical', 'El artículo no está publicado para la fecha actual.');
        }

        if (trim((string) $post->titulo) === '') {
            $findings[] = $this->finding('SEO-META-001', 'medium', 'El artículo no tiene título.');
        }

        if (trim(strip_tags((string) $post->contenido)) === '') {
            $findings[] = $this->finding('SEO-CONTENT-001', 'high', 'El artículo no tiene contenido publicable.');
        }

        if (trim((string) $post->metadescription) === '') {
            $findings[] = $this->finding(
                'SEO-META-001',
                'medium',
                'El artículo usará el fallback de descripción; se recomienda definir una meta descripción.'
            );
        }
    }

    private function hasValidSlug(?string $slug): bool
    {
        return is_string($slug) && preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug) === 1;
    }

    private function isDevelopmentUrl(string $url): bool
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        return $host === ''
            || Str::contains($host, ['.local', 'localhost', '127.0.0.1']);
    }

    private function score(array $findings): int
    {
        $deductions = ['critical' => 50, 'high' => 25, 'medium' => 10, 'low' => 5];
        $score = 100;

        foreach ($findings as $finding) {
            $score -= $deductions[$finding['severity']] ?? 0;
        }

        return max(0, $score);
    }

    private function finding(string $ruleCode, string $severity, string $message, array $evidence = []): array
    {
        return compact('severity', 'message', 'evidence') + [
            'rule_code' => $ruleCode,
        ];
    }
}
