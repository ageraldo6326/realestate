<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\RunSeoAudit;
use App\Models\SeoAuditResult;
use App\Models\SitemapVersion;
use App\Services\SeoHealthSummaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SeoAuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, SeoHealthSummaryService $summary)
    {
        Gate::authorize('seo-audit.view');

        $results = SeoAuditResult::query()->with('findings')->latest('last_checked_at');
        if ($request->filled('type')) {
            $results->where('auditable_type', $request->input('type'));
        }
        if ($request->filled('status')) {
            $results->where('status', $request->input('status'));
        }
        if ($request->filled('severity')) {
            $results->whereHas('findings', function ($query) use ($request): void {
                $query->where('severity', $request->input('severity'))->where('is_resolved', false);
            });
        }

        return view('admin.seo-audit.index', [
            'summary' => $summary->current(),
            'results' => $results->paginate(25)->appends($request->query()),
            'lastSitemap' => SitemapVersion::query()->latest('generated_at')->first(),
        ]);
    }

    public function run(Request $request): RedirectResponse
    {
        Gate::authorize('seo-audit.run');

        RunSeoAudit::dispatch('manual', (int) $request->user()->id);

        return redirect()->route('seo-audit.index')->with('status', 'La auditoría SEO fue enviada para ejecución.');
    }
}
