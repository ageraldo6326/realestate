<?php

namespace App\Http\Controllers;

use App\Services\InmobiliariaService;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $company = InmobiliariaService::get();
        $baseUrl = rtrim(InmobiliariaService::canonicalUrl($company), '/');
        $canonicalHost = strtolower((string) parse_url($baseUrl, PHP_URL_HOST));
        $requestHost = strtolower(request()->getHost());
        $isIndexableHost = $canonicalHost !== '' && hash_equals($canonicalHost, $requestHost);
        $directives = InmobiliariaService::indexingEnabled($company) && $isIndexableHost
            ? "User-agent: *\nAllow: /\nSitemap: {$baseUrl}/sitemap.xml\n"
            : "User-agent: *\nDisallow: /\n";

        return response($directives, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
