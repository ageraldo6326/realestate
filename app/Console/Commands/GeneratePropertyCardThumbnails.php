<?php

namespace App\Console\Commands;

use App\Models\Propiedad;
use App\Services\PropertyCardThumbnailService;
use Illuminate\Console\Command;

class GeneratePropertyCardThumbnails extends Command
{
    protected $signature = 'properties:generate-card-thumbnails
                            {--dry-run : Solo muestra cuantas miniaturas se pueden crear}';

    protected $description = 'Genera miniaturas WebP de 480 px para tarjetas sin alterar las imagenes originales.';

    public function handle(PropertyCardThumbnailService $thumbnails): int
    {
        $processed = 0;
        $created = 0;
        $skipped = 0;

        Propiedad::query()
            ->select(['id', 'foto_portada'])
            ->orderBy('id')
            ->chunkById(100, function ($properties) use ($thumbnails, &$processed, &$created, &$skipped): void {
                foreach ($properties as $property) {
                    if (empty($property->foto_portada)) {
                        continue;
                    }

                    $processed++;

                    if ($this->option('dry-run')) {
                        $skipped++;
                        continue;
                    }

                    if ($thumbnails->create($property->foto_portada) !== null) {
                        $created++;
                    } else {
                        $skipped++;
                    }
                }
            });

        $this->table(['Concepto', 'Cantidad'], [
            ['Referencias analizadas', (string) $processed],
            [$this->option('dry-run') ? 'Pendientes de generar' : 'Miniaturas disponibles', (string) ($this->option('dry-run') ? $skipped : $created)],
            ['Omitidas', (string) ($this->option('dry-run') ? 0 : $skipped)],
        ]);

        return self::SUCCESS;
    }
}
