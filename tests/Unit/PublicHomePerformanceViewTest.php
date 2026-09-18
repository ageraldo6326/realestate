<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PublicHomePerformanceViewTest extends TestCase
{
    public function test_home_preloads_the_lcp_image_and_reserves_image_space(): void
    {
        $root = dirname(__DIR__, 2);
        $home = file_get_contents($root . '/resources/views/frontend/home.blade.php');
        $header = file_get_contents($root . '/resources/views/layout/encabezado-landing.blade.php');

        $this->assertNotFalse($home);
        $this->assertNotFalse($header);
        $this->assertStringContainsString('rel="preload" as="image"', $home);
        $this->assertStringContainsString('fetchpriority="high"', $home);
        $this->assertStringContainsString('width="640" height="480" decoding="async"', $home);
        $this->assertStringContainsString("asset('img/brand/logo-home-192.webp')", $header);
        $this->assertStringContainsString('width="48" height="48"', $header);
        $this->assertFileExists($root . '/public/img/brand/logo-home-192.webp');
    }

    public function test_static_assets_receive_safe_cache_lifetimes(): void
    {
        $root = dirname(__DIR__, 2);
        $htaccess = file_get_contents($root . '/public/.htaccess');

        $this->assertNotFalse($htaccess);
        $this->assertStringContainsString('ExpiresByType image/webp "access plus 30 days"', $htaccess);
        $this->assertStringContainsString('Header set Cache-Control "public, max-age=2592000"', $htaccess);
        $this->assertStringContainsString('Header set Cache-Control "public, max-age=31536000, immutable"', $htaccess);
    }
}
