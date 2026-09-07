<button type="button"
    class="app-theme-toggle"
    wire:click="toggleTheme"
    wire:loading.attr="disabled"
    wire:target="toggleTheme"
    aria-pressed="{{ $theme === 'dark' ? 'true' : 'false' }}"
    aria-label="{{ $theme === 'dark' ? 'Activar modo claro' : 'Activar modo oscuro' }}"
    title="{{ $theme === 'dark' ? 'Activar modo claro' : 'Activar modo oscuro' }}">
    <span wire:loading.remove wire:target="toggleTheme" aria-hidden="true">
        <i class="{{ $theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon' }}"></i>
    </span>
    <span wire:loading wire:target="toggleTheme" aria-hidden="true">
        <i class="fas fa-circle-notch fa-spin"></i>
    </span>
    <span class="app-theme-toggle__label d-none d-xl-inline">
        {{ $theme === 'dark' ? 'Modo claro' : 'Modo oscuro' }}
    </span>
    <span class="sr-only">{{ $theme === 'dark' ? 'Activar modo claro' : 'Activar modo oscuro' }}</span>
</button>
