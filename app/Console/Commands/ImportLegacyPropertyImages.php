<?php

namespace App\Console\Commands;

use App\Events\PropertySaved;
use App\Models\Propiedad;
use App\Services\Images\PropertyImageService;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;

class ImportLegacyPropertyImages extends Command
{
    protected $signature = 'media:properties:import-legacy {propertyId? : ID de una propiedad}';
    protected $description = 'Copia imágenes públicas antiguas al sistema central sin borrarlas.';

    public function handle(PropertyImageService $propertyImages): int
    {
        $query = Propiedad::query()->orderBy('id');
        if ($propertyId = $this->argument('propertyId')) {
            $query->whereKey($propertyId);
        }

        $imported = 0;
        $query->chunkById(100, function ($properties) use ($propertyImages, &$imported): void {
            foreach ($properties as $property) {
                foreach (['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'] as $slot) {
                    $path = (string) $property->{$slot};
                    $absolutePath = public_path(ltrim($path, '/'));

                    if ($path === '' || ! is_file($absolutePath) || ! @getimagesize($absolutePath) || $property->images()->where('slot', $slot)->exists()) {
                        continue;
                    }

                    $propertyImages->store(new UploadedFile($absolutePath, basename($absolutePath), null, null, true), $property, $slot);
                    $imported++;
                }

                if ($property->images()->where('status', 'pending')->exists()) {
                    PropertySaved::dispatch($property);
                }
            }
        });

        $this->info("Se importaron {$imported} imágenes para procesar.");

        return self::SUCCESS;
    }
}
