<?php

namespace App\Http\Controllers;

use App\Services\SitemapService;
use Illuminate\Http\Response;

class Sitemap extends Controller
{
    public function sitemap(SitemapService $sitemapService): Response
    {
        $xml = $sitemapService->getXml();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=900');
    }
}
