<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Modern sidebar
    |--------------------------------------------------------------------------
    |
    | The legacy AdminLTE sidebar remains the default. Set MODERN_SIDEBAR=true
    | to enable the visual navigation introduced for the CRM.
    |
    */
    'modern_sidebar' => (bool) env('MODERN_SIDEBAR', false),

    /*
    |--------------------------------------------------------------------------
    | Dark mode
    |--------------------------------------------------------------------------
    |
    | The saved user preference is preserved when this flag is disabled, but
    | the authenticated panel is rendered in light mode and the toggle is hidden.
    |
    */
    'dark_mode_enabled' => (bool) env('DARK_MODE_ENABLED', false),
];
