<?php

namespace App\Services;

use App\Models\SeoAuditFinding;
use App\Models\SeoAuditResult;
use App\Models\SeoAuditRun;
use Illuminate\Support\Facades\Schema;

class SeoHealthSummaryService
{
    public function current(): array
    {
        if (!Schema::hasTable('seo_audit_results')) {
            return $this->emptySummary();
        }

        $results = SeoAuditResult::query();
        $byStatus = (clone $results)->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $criticalFindings = Schema::hasTable('seo_audit_findings')
            ? SeoAuditFinding::query()->whereIn('severity', ['critical', 'high'])->where('is_resolved', false)->count()
            : 0;

        return [
            'total' => (clone $results)->count(),
            'indexable' => (clone $results)->where('is_indexable', true)->count(),
            'in_sitemap' => (clone $results)->where('is_in_sitemap', true)->count(),
            'blocked' => (clone $results)->where('is_indexable', false)->count(),
            'green' => (int) ($byStatus['green'] ?? 0),
            'yellow' => (int) ($byStatus['yellow'] ?? 0),
            'red' => (int) ($byStatus['red'] ?? 0),
            'critical_findings' => $criticalFindings,
            'last_run' => Schema::hasTable('seo_audit_runs')
                ? SeoAuditRun::query()->where('status', 'completed')->latest('finished_at')->first()
                : null,
        ];
    }

    private function emptySummary(): array
    {
        return [
            'total' => 0,
            'indexable' => 0,
            'in_sitemap' => 0,
            'blocked' => 0,
            'green' => 0,
            'yellow' => 0,
            'red' => 0,
            'critical_findings' => 0,
            'last_run' => null,
        ];
    }
}
