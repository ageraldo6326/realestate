<?php

namespace App\Listeners;

use App\Events\PropertySaved;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ImagePropertyOptimizer implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PropertySaved  $event
     * @return void
     */
    public function handle(PropertySaved $event)
    {
        try {
            $withWatermark = (bool) $event->propiedad->marcadeagua;

            foreach (['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'] as $field) {
                $relativePath = (string) data_get($event->propiedad, $field);

                if ($relativePath === '') {
                    continue;
                }

                $absolutePath = public_path(ltrim($relativePath, '/'));
                if (!file_exists($absolutePath)) {
                    continue;
                }

                $this->processImage($absolutePath, $withWatermark, (int) $event->propiedad->id, $field, $relativePath);
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    protected function processImage(string $absolutePath, bool $withWatermark, int $propertyId, string $field, string $relativePath): void
    {
        try {
            $backupPath = $absolutePath . '.orig';

            if ($withWatermark) {
                if (!file_exists($backupPath)) {
                    copy($absolutePath, $backupPath);
                }

                $logoPath = public_path('assets/inmobiliaria/logo.png');
                if (!file_exists($logoPath)) {
                    return;
                }

                $base = Image::make($backupPath)->fit(850, 650);
                $targetLogoWidth = max(90, (int) round($base->width() * 0.18));
                $watermark = Image::make($logoPath)
                    ->widen($targetLogoWidth, function ($constraint) {
                        $constraint->upsize();
                    })
                    ->opacity(50);

                $base->insert($watermark, 'center')->save($absolutePath, 90);
                return;
            }

            if (file_exists($backupPath)) {
                copy($backupPath, $absolutePath);
            } elseif (Storage::disk('local')->exists(ltrim($relativePath, '/'))) {
                file_put_contents($absolutePath, Storage::disk('local')->get(ltrim($relativePath, '/')));
            }
        } catch (\Throwable $exception) {
            Log::warning('No se pudo procesar imagen de propiedad.', [
                'propiedad_id' => $propertyId,
                'field' => $field,
                'path' => $relativePath,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
