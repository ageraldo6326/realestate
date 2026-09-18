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
        $this->assertStringContainsString('type="image/webp" media="(max-width: 767px)"', $home);
        $this->assertStringContainsString('<picture class="hero-media"', $home);
        $this->assertStringContainsString('fetchpriority="high"', $home);
        $this->assertStringContainsString('width="640" height="480" decoding="async"', $home);
        $this->assertStringContainsString("asset('img/brand/logo-home-192.webp')", $header);
        $this->assertStringContainsString('width="48" height="48"', $header);
        $this->assertStringContainsString("asset('css/bootstrap-5.3.2.min.css')", $header);
        $this->assertStringContainsString('display=optional', $header);
        $this->assertStringContainsString('rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"', $header);
        $this->assertStringContainsString('Los iconos no afectan la estructura inicial', $header);
        $this->assertStringContainsString('navbar-toggler-icon', $header);
        $this->assertStringContainsString('PropertyCardThumbnailService', $home);
        $this->assertStringContainsString('sizes="(max-width: 767px) 100vw', $home);
        $this->assertFileExists($root . '/public/img/brand/logo-home-192.webp');
        $this->assertFileExists($root . '/public/css/bootstrap-5.3.2.min.css');
        $this->assertFileExists($root . '/public/assets/portada-hero-640.webp');
        $this->assertFileExists($root . '/public/assets/portada-hero-1280.webp');
        $this->assertSame(640, getimagesize($root . '/public/assets/portada-hero-640.webp')[0]);
        $this->assertSame(1280, getimagesize($root . '/public/assets/portada-hero-1280.webp')[0]);
    }

    public function test_static_assets_receive_safe_cache_lifetimes(): void
    {
        $root = dirname(__DIR__, 2);
        $htaccess = file_get_contents($root . '/public/.htaccess');

        $this->assertNotFalse($htaccess);
        $this->assertStringContainsString('ExpiresByType image/webp "access plus 30 days"', $htaccess);
        $this->assertStringContainsString('Header set Cache-Control "public, max-age=2592000"', $htaccess);
        $this->assertStringContainsString('Header set Cache-Control "public, max-age=31536000, immutable"', $htaccess);
        $this->assertStringContainsString('<Files "bootstrap-5.3.2.min.css">', $htaccess);
        $this->assertStringContainsString('<IfModule mod_deflate.c>', $htaccess);
        $this->assertStringContainsString('AddOutputFilterByType DEFLATE text/css', $htaccess);
    }
}
