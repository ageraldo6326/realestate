<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ThemeToggle extends Component
{
    /** @var string */
    public $theme = 'light';

    public function mount(): void
    {
        $this->theme = $this->resolveTheme();
    }

    public function toggleTheme(): void
    {
        if (!config('ui.dark_mode_enabled')) {
            $this->theme = 'light';

            return;
        }

        $user = Auth::user();

        if (!$user) {
            return;
        }

        $nextTheme = $this->theme === 'dark' ? 'light' : 'dark';

        if (!in_array($nextTheme, ['light', 'dark'], true)) {
            return;
        }

        $user->forceFill(['ui_theme' => $nextTheme])->save();

        $this->theme = $nextTheme;
        $this->dispatchBrowserEvent('ui-theme-changed', ['theme' => $nextTheme]);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }

    private function resolveTheme(): string
    {
        if (!config('ui.dark_mode_enabled')) {
            return 'light';
        }

        return optional(Auth::user())->ui_theme === 'dark' ? 'dark' : 'light';
    }
}
