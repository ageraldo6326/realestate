<?php

namespace App\Services;

use App\Jobs\RunSeoAudit;
use App\Models\SeoAuditResult;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SitemapInvalidationService
{
    public function invalidate(string $trigger, $entity = null): void
    {
        app(SitemapService::class)->forget();

        if (!Schema::hasTable('seo_audit_runs')) {
            return;
        }

        $type = null;
        $id = null;
        if ($entity !== null) {
            $type = app(CanonicalUrlService::class)->typeFor($entity);
            $id = (int) $entity->getKey();
        }

        if (substr($trigger, -8) === '.deleted' && Schema::hasTable('seo_audit_results')) {
            SeoAuditResult::query()
                ->where('auditable_type', $type)
                ->where('auditable_id', $id)
                ->get()
                ->each(function (SeoAuditResult $result): void {
                    $result->findings()->delete();
                    $result->delete();
                });
        }

        $key = 'seo.audit.pending.' . sha1($trigger . ':' . $type . ':' . $id);
        if (Cache::add($key, true, now()->addMinute())) {
            RunSeoAudit::dispatch($trigger, null, $type, $id);
        }
    }
}
