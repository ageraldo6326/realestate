<?php

namespace App\Providers;

use App\Models\Inmobiliaria;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->ensureFrameworkStorageDirectories();
        $this->ensurePublicAssetDirectories();

        Paginator::useBootstrap();
        $inmo = Inmobiliaria::first();
        View::share('inmo', $inmo);
    }

    /**
     * Ensure framework storage directories exist to avoid runtime write errors.
     */
    protected function ensureFrameworkStorageDirectories(): void
    {
        $directories = [
            storage_path('framework/cache'),
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
        ];

        foreach ($directories as $directory) {
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
        }
    }

    /**
     * Ensure public asset directories exist for generated images.
     */
    protected function ensurePublicAssetDirectories(): void
    {
        $directories = [
            public_path('assets'),
            public_path('assets/enfoque'),
            public_path('assets/portada'),
            public_path('assets/post'),
            public_path('assets/propiedades'),
            public_path('assets/testimonio'),
            public_path('assets/usuario'),
        ];

        foreach ($directories as $directory) {
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
        }
    }
}
