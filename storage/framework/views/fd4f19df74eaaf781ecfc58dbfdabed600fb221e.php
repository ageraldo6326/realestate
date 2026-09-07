<button type="button"
    class="app-theme-toggle"
    wire:click="toggleTheme"
    wire:loading.attr="disabled"
    wire:target="toggleTheme"
    aria-pressed="<?php echo e($theme === 'dark' ? 'true' : 'false'); ?>"
    aria-label="<?php echo e($theme === 'dark' ? 'Activar modo claro' : 'Activar modo oscuro'); ?>"
    title="<?php echo e($theme === 'dark' ? 'Activar modo claro' : 'Activar modo oscuro'); ?>">
    <span wire:loading.remove wire:target="toggleTheme" aria-hidden="true">
        <i class="<?php echo e($theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon'); ?>"></i>
    </span>
    <span wire:loading wire:target="toggleTheme" aria-hidden="true">
        <i class="fas fa-circle-notch fa-spin"></i>
    </span>
    <span class="app-theme-toggle__label d-none d-xl-inline">
        <?php echo e($theme === 'dark' ? 'Modo claro' : 'Modo oscuro'); ?>

    </span>
    <span class="sr-only"><?php echo e($theme === 'dark' ? 'Activar modo claro' : 'Activar modo oscuro'); ?></span>
</button>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/livewire/theme-toggle.blade.php ENDPATH**/ ?>