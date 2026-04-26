<?php

namespace App\Console\Commands;

use App\Models\Propiedad;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class EnsurePropertyCoverImages extends Command
{
  protected $signature = 'properties:ensure-cover-images
                            {--refresh-all : Reasigna imagen de portada a todas las propiedades}
                            {--force : Ejecutar sin confirmacion interactiva}';

  protected $description = 'Garantiza que todas las propiedades tengan al menos una imagen de portada valida.';

  public function handle(): int
  {
    if (!$this->option('force') && !$this->confirm('Deseas completar imagenes de portada faltantes?', true)) {
      $this->info('Operacion cancelada.');
      return self::SUCCESS;
    }

    try {
      $imagePool = $this->getAvailableImagePool();

      if (count($imagePool) === 0) {
        $this->error('No hay imagenes disponibles en public/assets para asignar portada.');
        $this->line('Ejecuta primero: php artisan demo:fetch-images --force');
        return self::FAILURE;
      }

      $propiedades = Propiedad::query()
        ->orderBy('id')
        ->get(['id', 'referencia', 'foto_portada']);

      if ($propiedades->isEmpty()) {
        $this->info('No hay propiedades pendientes de asignacion.');
        return self::SUCCESS;
      }

      $updated = 0;
      $counter = 0;
      foreach ($propiedades as $propiedad) {
        if (!$this->shouldReplaceCoverImage($propiedad->foto_portada)) {
          continue;
        }

        $image = $imagePool[$counter % count($imagePool)];

        $propiedad->update([
          'foto_portada' => $image,
        ]);

        $updated++;
        $counter++;
      }

      if ($updated > 0) {
        $this->table(
          ['Metric', 'Count'],
          [
            ['Updated', (string) $updated],
            ['Image Pool', (string) count($imagePool)],
          ]
        );
      }

      $this->info('Proceso completado: todas las propiedades tienen imagen de portada.');

      return self::SUCCESS;
    } catch (Throwable $e) {
      $this->error('Error ejecutando properties:ensure-cover-images');
      $this->error($e->getMessage());

      return self::FAILURE;
    }
  }

  /**
   * @return array<int, string>
   */
  private function getAvailableImagePool(): array
  {
    $candidateFiles = [
      'prop-apto-1.jpg',
      'prop-apto-2.jpg',
      'prop-apto-3.jpg',
      'prop-apto-4.jpg',
      'prop-casa-1.jpg',
      'prop-villa-1.jpg',
      'prop-oficina-1.jpg',
    ];

    $pool = [];
    foreach ($candidateFiles as $file) {
      if (File::exists(public_path('assets/' . $file))) {
        $pool[] = $file;
      }
    }

    return $pool;
  }

  private function shouldReplaceCoverImage(?string $coverImage): bool
  {
    if ($this->option('refresh-all')) {
      return true;
    }

    $coverImage = trim((string) $coverImage);
    if ($coverImage === '') {
      return true;
    }

    $normalized = (string) Str::of($coverImage)->lower()->replace('\\', '/');

    // Evita usar logos/rutas de logo como portada
    if (str_contains($normalized, 'logo')) {
      return true;
    }

    // Si el archivo no existe en assets, reasignar
    if (!File::exists(public_path('assets/' . $coverImage))) {
      return true;
    }

    return false;
  }
}
