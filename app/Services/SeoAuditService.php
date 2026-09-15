<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Propiedad;
use App\Models\SeoAuditResult;
use App\Models\SeoAuditRun;
use App\Models\Zonas;
use Illuminate\Support\Facades\Schema;

class SeoAuditService
{
    private IndexabilityPolicy $policy;
    private CanonicalUrlService $canonicalUrls;
    private SitemapService $sitemap;
    private SeoHealthSummaryService $summary;

    public function __construct(
        IndexabilityPolicy $policy,
        CanonicalUrlService $canonicalUrls,
        SitemapService $sitemap,
        SeoHealthSummaryService $summary
    ) {
        $this->policy = $policy;
        $this->canonicalUrls = $canonicalUrls;
        $this->sitemap = $sitemap;
        $this->summary = $summary;
    }

    public function run(string $trigger = 'manual', ?int $initiatedBy = null, ?string $entityType = null, ?int $entityId = null): ?SeoAuditRun
    {
        if (!Schema::hasTable('seo_audit_runs') || !Schema::hasTable('seo_audit_results')) {
            return null;
        }

        $company = InmobiliariaService::get();
        $run = SeoAuditRun::query()->create([
            'inmobiliaria_id' => optional($company)->id,
            'trigger' => $trigger,
            'status' => 'running',
            'initiated_by' => $initiatedBy,
            'started_at' => now(),
        ]);

        try {
            $sitemapUrls = $this->sitemapUrls($this->sitemap->getXml());
            foreach ($this->candidates($entityType, $entityId) as $candidate) {
                $this->storeResult($run, $company, $candidate['type'], $candidate['entity'], $candidate['title'], $sitemapUrls);
            }

            $run->update([
                'status' => 'completed',
                'finished_at' => now(),
                'summary_json' => $this->summary->current(),
            ]);
        } catch (\Throwable $exception) {
            $run->update([
                'status' => 'failed',
                'finished_at' => now(),
                'summary_json' => ['error' => $exception->getMessage()],
            ]);

            throw $exception;
        }

        return $run->fresh();
    }

    private function candidates(?string $entityType, ?int $entityId): \Generator
    {
        if ($entityType !== null) {
            $entity = $this->findEntity($entityType, $entityId);
            if ($entity !== null) {
                yield ['type' => $entityType, 'entity' => $entity, 'title' => $this->titleFor($entityType, $entity)];
            }

            return;
        }

        foreach ($this->canonicalUrls->publicPages() as $page) {
            yield ['type' => 'page', 'entity' => $page, 'title' => $page];
        }

        if (Schema::hasTable('propiedads')) {
            foreach (Propiedad::query()->orderBy('id')->cursor() as $property) {
                yield ['type' => 'property', 'entity' => $property, 'title' => $this->titleFor('property', $property)];
            }
        }

        if (Schema::hasTable('zonas')) {
            foreach (Zonas::query()->orderBy('id')->cursor() as $zone) {
                yield ['type' => 'zone', 'entity' => $zone, 'title' => $this->titleFor('zone', $zone)];
            }
        }

        if (Schema::hasTable('posts')) {
            foreach (Post::query()->orderBy('id')->cursor() as $post) {
                yield ['type' => 'post', 'entity' => $post, 'title' => $this->titleFor('post', $post)];
            }
        }
    }

    private function findEntity(string $type, ?int $id)
    {
        if (!$id) {
            return null;
        }

        $models = [
            'property' => Propiedad::class,
            'zone' => Zonas::class,
            'post' => Post::class,
        ];

        if (!isset($models[$type])) {
            return null;
        }

        return $models[$type]::query()->find($id);
    }

    private function storeResult(SeoAuditRun $run, $company, string $type, $entity, string $title, array $sitemapUrls): void
    {
        $evaluation = $this->policy->evaluate($type, $entity);
        $canonical = $evaluation['canonical_url'];
        $entityId = $type === 'page' ? null : $entity->getKey();
        $isInSitemap = in_array(rtrim($canonical, '/'), $sitemapUrls, true);
        $this->appendSitemapFinding($evaluation, $isInSitemap);

        $query = SeoAuditResult::query()
            ->where('inmobiliaria_id', optional($company)->id)
            ->where('auditable_type', $type);
        $entityId === null ? $query->whereNull('auditable_id') : $query->where('auditable_id', $entityId);

        $result = $query->first() ?: new SeoAuditResult([
            'inmobiliaria_id' => optional($company)->id,
            'auditable_type' => $type,
            'auditable_id' => $entityId,
        ]);

        $result->fill([
            'seo_audit_run_id' => $run->id,
            'entity_title' => $title,
            'canonical_url' => $canonical,
            'is_indexable' => $evaluation['is_indexable'],
            'is_in_sitemap' => $isInSitemap,
            'score' => $evaluation['score'],
            'status' => $evaluation['status'],
            'last_http_status' => $evaluation['last_http_status'],
            'last_checked_at' => now(),
            'lastmod_at' => $evaluation['lastmod_at'],
        ])->save();

        $result->findings()->delete();
        foreach ($evaluation['findings'] as $finding) {
            $result->findings()->create([
                'rule_code' => $finding['rule_code'],
                'severity' => $finding['severity'],
                'message' => $finding['message'],
                'evidence_json' => $finding['evidence'],
                'is_resolved' => false,
            ]);
        }
    }

    private function sitemapUrls(string $xml): array
    {
        preg_match_all('/<loc>(.*?)<\\/loc>/', $xml, $matches);

        return array_values(array_unique(array_map(static function (string $url): string {
            return rtrim(html_entity_decode($url, ENT_XML1, 'UTF-8'), '/');
        }, $matches[1] ?? [])));
    }

    private function titleFor(string $type, $entity): string
    {
        if ($type === 'property' || $type === 'post') {
            return (string) ($entity->titulo ?: $entity->slug);
        }

        if ($type === 'zone') {
            return (string) ($entity->zona ?: $entity->slug);
        }

        return (string) $entity;
    }

    private function appendSitemapFinding(array &$evaluation, bool $isInSitemap): void
    {
        if ($evaluation['is_indexable'] && !$isInSitemap) {
            $evaluation['findings'][] = [
                'rule_code' => 'SEO-SITEMAP-001',
                'severity' => 'high',
                'message' => 'La URL es indexable, pero no fue incluida en el sitemap dinámico.',
                'evidence' => ['canonical_url' => $evaluation['canonical_url']],
            ];
            $evaluation['score'] = max(0, $evaluation['score'] - 25);
            $evaluation['status'] = 'red';
        }

        if (!$evaluation['is_indexable'] && $isInSitemap) {
            $evaluation['findings'][] = [
                'rule_code' => 'SEO-SITEMAP-002',
                'severity' => 'critical',
                'message' => 'La URL está bloqueada para indexación, pero aparece en el sitemap.',
                'evidence' => ['canonical_url' => $evaluation['canonical_url']],
            ];
            $evaluation['score'] = max(0, $evaluation['score'] - 50);
            $evaluation['status'] = 'red';
        }
    }
}
