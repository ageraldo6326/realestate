<?php

return [
    'canonical_url' => env('SEO_CANONICAL_URL', env('APP_URL', 'http://localhost')),
    'indexing_enabled' => filter_var(env('SEO_INDEXING_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
    'public_cache_seconds' => (int) env('SEO_PUBLIC_CACHE_SECONDS', 300),
    'shared_cache_seconds' => (int) env('SEO_SHARED_CACHE_SECONDS', 600),
    'audit_daily_at' => env('SEO_AUDIT_DAILY_AT', '03:30'),
    'csp_report_only' => env(
        'SEO_CSP_REPORT_ONLY',
        "default-src 'self' https: data: blob:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' https: data: blob:; font-src 'self' https: data:; connect-src 'self' https: wss:; frame-src 'self' https:; object-src 'none'; base-uri 'self'; frame-ancestors 'self'"
    ),
];
