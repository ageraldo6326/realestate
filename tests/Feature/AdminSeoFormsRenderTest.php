<?php

namespace Tests\Feature;

use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class AdminSeoFormsRenderTest extends TestCase
{
    public function test_blog_form_renders_publication_and_image_seo_fields(): void
    {
        $html = view('admin.posts._form', [
            'mode' => 'create',
            'action' => '/admin/posts',
            'errors' => new ViewErrorBag(),
        ])->render();

        $this->assertStringContainsString('name="seo_title"', $html);
        $this->assertStringContainsString('name="published_at"', $html);
        $this->assertStringContainsString('name="image_alt"', $html);
        $this->assertStringContainsString('name="image_credit"', $html);
        $this->assertStringContainsString('maxlength="160"', $html);
    }

    public function test_zone_form_renders_editorial_and_indexability_fields(): void
    {
        $html = view('admin.zonas._form', [
            'mode' => 'create',
            'action' => '/admin/zonas',
            'errors' => new ViewErrorBag(),
        ])->render();

        $this->assertStringContainsString('name="is_public"', $html);
        $this->assertStringContainsString('name="seo_h1"', $html);
        $this->assertStringContainsString('name="meta_description"', $html);
        $this->assertStringContainsString('name="seo_description"', $html);
        $this->assertStringContainsString('enctype="multipart/form-data"', $html);
    }
}
