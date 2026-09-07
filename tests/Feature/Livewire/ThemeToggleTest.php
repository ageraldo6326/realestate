<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ThemeToggle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ThemeToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_persists_the_theme_for_only_the_authenticated_user(): void
    {
        config()->set('ui.dark_mode_enabled', true);

        $user = User::factory()->create(['ui_theme' => 'light']);
        $otherUser = User::factory()->create(['ui_theme' => 'light']);

        $this->actingAs($user);

        Livewire::test(ThemeToggle::class)
            ->call('toggleTheme')
            ->assertSet('theme', 'dark');

        $this->assertSame('dark', $user->fresh()->ui_theme);
        $this->assertSame('light', $otherUser->fresh()->ui_theme);
    }

    public function test_disabled_feature_keeps_the_panel_in_light_mode(): void
    {
        config()->set('ui.dark_mode_enabled', false);

        $user = User::factory()->create(['ui_theme' => 'dark']);
        $this->actingAs($user);

        Livewire::test(ThemeToggle::class)
            ->call('toggleTheme')
            ->assertSet('theme', 'light');

        $this->assertSame('dark', $user->fresh()->ui_theme);
    }
}
