<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $baseUrl = rtrim((string) config('seo.canonical_url', config('app.url')), '/');
        $canonicalHost = strtolower((string) parse_url($baseUrl, PHP_URL_HOST));
        $requestHost = strtolower(request()->getHost());
        $isIndexableHost = $canonicalHost !== '' && hash_equals($canonicalHost, $requestHost);
        $directives = config('seo.indexing_enabled') && $isIndexableHost
            ? "User-agent: *\nAllow: /\nSitemap: {$baseUrl}/sitemap.xml\n"
            : "User-agent: *\nDisallow: /\n";

        return response($directives, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
