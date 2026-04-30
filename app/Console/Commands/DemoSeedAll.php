<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class DemoSeedAll extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'demo:seed-all {--force : Ejecutar sin confirmacion interactiva}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Ejecuta todos los seeders de demo (catalogos + datos del home) para pruebas y demos.';

  public function handle(): int
  {
    if (!$this->option('force') && !$this->confirm('Deseas poblar la base con datos de demo?', true)) {
      $this->info('Operacion cancelada.');
      return self::SUCCESS;
    }

    try {
      $steps = [
        [
          'label' => 'Descargando imagenes de demo',
          'command' => 'demo:fetch-images',
          'arguments' => ['--force' => true],
        ],
        [
          'label' => 'Ejecutando MesesSeeder',
          'command' => 'db:seed',
          'arguments' => ['--class' => 'Database\\Seeders\\MesesSeeder', '--force' => true],
        ],
        [
          'label' => 'Ejecutando CatalogosSeeder',
          'command' => 'db:seed',
          'arguments' => ['--class' => 'Database\\Seeders\\CatalogosSeeder', '--force' => true],
        ],
        [
          'label' => 'Ejecutando HomeDataSeeder',
          'command' => 'db:seed',
          'arguments' => ['--class' => 'Database\\Seeders\\HomeDataSeeder', '--force' => true],
        ],
        [
          'label' => 'Completando avatares de asesores demo',
          'command' => 'demo:ensure-advisor-avatars',
          'arguments' => ['--force' => true],
        ],
        [
          'label' => 'Completando imagenes de portada en propiedades',
          'command' => 'properties:ensure-cover-images',
          'arguments' => ['--force' => true],
        ],
      ];

      foreach ($steps as $index => $step) {
        $position = $index + 1;
        $this->info("{$position}/" . count($steps) . " {$step['label']}...");

        Artisan::call($step['command'], $step['arguments']);
        $this->output->write(Artisan::output());
      }

      $this->newLine();
      $this->info('Seeders de demo ejecutados correctamente.');

      return self::SUCCESS;
    } catch (Throwable $e) {
      $this->error('Error ejecutando demo:seed-all');
      $this->error($e->getMessage());

      return self::FAILURE;
    }
  }
}
