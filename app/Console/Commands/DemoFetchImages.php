<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Throwable;

class DemoFetchImages extends Command
{
  protected $signature = 'demo:fetch-images
                            {--refresh : Re-descarga archivos aunque ya existan}
                            {--force : Ejecutar sin confirmacion interactiva}';

  protected $description = 'Descarga imagenes de demo libres de uso (Pexels CDN) para portada, propiedades, posts y testimonios.';

  public function handle(): int
  {
    if (!$this->option('force') && !$this->confirm('Deseas descargar/actualizar imagenes de demo?', true)) {
      $this->info('Operacion cancelada.');
      return self::SUCCESS;
    }

    $assetDir = public_path('assets');
    File::ensureDirectoryExists($assetDir);

    // Fuentes: Pexels CDN (licencia Pexels). Verificar terminos vigentes antes de uso comercial.
    $images = [
      'portada-hero.jpg'  => 'https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg?auto=compress&cs=tinysrgb&w=1600',
      'prop-apto-1.jpg'   => 'https://images.pexels.com/photos/439391/pexels-photo-439391.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'prop-apto-2.jpg'   => 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'prop-apto-3.jpg'   => 'https://images.pexels.com/photos/6585757/pexels-photo-6585757.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'prop-apto-4.jpg'   => 'https://images.pexels.com/photos/7031408/pexels-photo-7031408.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'prop-casa-1.jpg'   => 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'prop-villa-1.jpg'  => 'https://images.pexels.com/photos/32870/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=1200',
      'prop-oficina-1.jpg' => 'https://images.pexels.com/photos/245240/pexels-photo-245240.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'post-1.jpg'        => 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'post-2.jpg'        => 'https://images.pexels.com/photos/186077/pexels-photo-186077.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'post-3.jpg'        => 'https://images.pexels.com/photos/7578913/pexels-photo-7578913.jpeg?auto=compress&cs=tinysrgb&w=1200',
      'cliente-1.jpg'     => 'https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg?auto=compress&cs=tinysrgb&w=800',
      'cliente-2.jpg'     => 'https://images.pexels.com/photos/91227/pexels-photo-91227.jpeg?auto=compress&cs=tinysrgb&w=800',
      'cliente-3.jpg'     => 'https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg?auto=compress&cs=tinysrgb&w=800',
    ];

    $downloaded = 0;
    $skipped = 0;
    $failed = 0;

    foreach ($images as $fileName => $url) {
      $filePath = $assetDir . DIRECTORY_SEPARATOR . $fileName;

      if (!$this->option('refresh') && File::exists($filePath)) {
        $this->line("- Ya existe: {$fileName}");
        $skipped++;
        continue;
      }

      try {
        $response = Http::timeout(30)
          ->withHeaders(['User-Agent' => 'realestate-demo-seeder/1.0'])
          ->get($url);

        if (!$response->ok() || empty($response->body())) {
          $this->warn("- No se pudo descargar: {$fileName}");
          $failed++;
          continue;
        }

        File::put($filePath, $response->body());
        $this->info("- Descargada: {$fileName}");
        $downloaded++;
      } catch (Throwable $e) {
        $this->warn("- Error descargando {$fileName}: " . $e->getMessage());
        $failed++;
      }
    }

    $this->newLine();
    $this->table(
      ['Metric', 'Count'],
      [
        ['Downloaded', (string) $downloaded],
        ['Skipped', (string) $skipped],
        ['Failed', (string) $failed],
      ]
    );

    if ($failed > 0) {
      $this->warn('Se completo con algunas descargas fallidas. Puedes reintentar con --refresh.');
    } else {
      $this->info('Imagenes de demo listas.');
    }

    return self::SUCCESS;
  }
}
