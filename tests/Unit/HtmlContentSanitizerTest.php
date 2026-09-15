<?php

namespace Tests\Unit;

use App\Services\HtmlContentSanitizer;
use PHPUnit\Framework\TestCase;

class HtmlContentSanitizerTest extends TestCase
{
    public function test_it_preserves_editorial_structure_and_removes_executable_markup(): void
    {
        $html = '<div><h2>Zona</h2><p onclick="alert(1)">Texto <strong>útil</strong>.</p>'
            . '<script>alert(2)</script><a href="javascript:alert(3)">Enlace</a></div>';

        $clean = (new HtmlContentSanitizer())->sanitize($html);

        $this->assertStringContainsString('<h2>Zona</h2>', $clean);
        $this->assertStringContainsString('<strong>útil</strong>', $clean);
        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('onclick', $clean);
        $this->assertStringNotContainsString('javascript:', $clean);
    }

    public function test_it_converts_plain_text_paragraphs_and_line_breaks_to_safe_html(): void
    {
        $content = "Primer párrafo.\n\nSegundo párrafo.\nCaracterística adicional & segura.";

        $clean = (new HtmlContentSanitizer())->sanitizePreservingLineBreaks($content);

        $this->assertStringContainsString('<p>Primer párrafo.</p>', $clean);
        $this->assertStringContainsString('Segundo párrafo.<br>', $clean);
        $this->assertStringContainsString('Característica adicional &amp; segura.', $clean);
    }
}
