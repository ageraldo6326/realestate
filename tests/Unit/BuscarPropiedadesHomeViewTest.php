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
            'wire:target="titulo_criterio,provincia_id_criterio,sector_barrio_criterio,tipo_id_criterio,precio_inicial,precio_final"',
            $view
        );
        $this->assertStringContainsString('class="lw-loading-content"', $view);
        $this->assertMatchesRegularExpression('/\\.lw-loading-content\\s*\\{[^}]*display\\s*:\\s*flex/s', $view);
    }

    public function test_title_filter_and_mobile_first_layout_are_rendered(): void
    {
        $view = file_get_contents(
            dirname(__DIR__, 2) . '/resources/views/livewire/buscar-propiedades-home.blade.php'
        );

        $this->assertNotFalse($view);
        $this->assertStringContainsString('wire:model.debounce.500ms="titulo_criterio"', $view);
        $this->assertStringContainsString('class="lw-search-grid"', $view);
        $this->assertMatchesRegularExpression(
            '/\\.lw-search-grid\\s*\\{[^}]*grid-template-columns\\s*:\\s*minmax\\(0, 1fr\\)/s',
            $view
        );
        $this->assertStringContainsString('@media (min-width: 768px)', $view);
        $this->assertStringContainsString('@media (min-width: 1200px)', $view);
    }

    public function test_hero_search_is_removed_and_title_query_is_configured(): void
    {
        $root = dirname(__DIR__, 2);
        $home = file_get_contents($root . '/resources/views/frontend/home.blade.php');
        $component = file_get_contents($root . '/app/Http/Livewire/BuscarPropiedadesHome.php');

        $this->assertNotFalse($home);
        $this->assertNotFalse($component);
        $this->assertStringNotContainsString('hero-search-box', $home);
        $this->assertStringNotContainsString('id="hero-provincia"', $home);
        $this->assertStringContainsString('public $titulo_criterio = \'\';', $component);
        $this->assertStringContainsString("where('propiedads.titulo', 'like'", $component);
    }
}
