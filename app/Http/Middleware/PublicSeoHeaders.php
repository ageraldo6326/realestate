<?php

namespace App\Http\Middleware;

use App\Services\InmobiliariaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicSeoHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Content-Security-Policy-Report-Only', (string) config('seo.csp_report_only'));

        if ($request->secure() && app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $company = InmobiliariaService::get();
        $canonicalHost = strtolower((string) parse_url(InmobiliariaService::canonicalUrl($company), PHP_URL_HOST));
        $requestHost = strtolower($request->getHost());
        $isCanonicalHost = $canonicalHost !== '' && hash_equals($canonicalHost, $requestHost);

        if (!InmobiliariaService::indexingEnabled($company) || !$isCanonicalHost || $response->getStatusCode() >= 400) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        if ($request->isMethod('GET') && !Auth::check() && $response->isSuccessful()) {
            $browserTtl = max(0, (int) config('seo.public_cache_seconds', 300));
            $sharedTtl = max($browserTtl, (int) config('seo.shared_cache_seconds', 600));
            $response->headers->set('Cache-Control', "public, max-age={$browserTtl}, s-maxage={$sharedTtl}");
        }

        return $response;
    }
}
