<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class BuscarPropiedadesHomeViewTest extends TestCase
{
    public function test_loading_indicator_is_only_displayed_during_a_filter_request(): void
    {
        $view = file_get_contents(
            dirname(__DIR__, 2) . '/resources/views/livewire/buscar-propiedades-home.blade.php'
        );

        $this->assertNotFalse($view);
        $this->assertStringContainsString('wire:loading.delay.shortest', $view);
        $this->assertStringNotContainsString('wire:loading.flex.delay.shortest', $view);
        $this->assertStringContainsString(
            'wire:target="provincia_id_criterio,sector_barrio_criterio,tipo_id_criterio,precio_inicial,precio_final"',
            $view
        );
        $this->assertStringContainsString('class="lw-loading-content"', $view);
        $this->assertMatchesRegularExpression('/\\.lw-loading-content\\s*\\{[^}]*display\\s*:\\s*flex/s', $view);
    }
}
